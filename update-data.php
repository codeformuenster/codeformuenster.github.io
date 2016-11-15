<?php

error_reporting( E_ALL ^ E_NOTICE );



function userCmp( $a, $b ) {
    if ($a['count'] == $b['count']) {
        return 0;
    }
    return ($a['count'] < $b['count']) ? 1 : -1;
}

function repoSort( $a, $b ) {
	if ( $a['image'] && !$b[image] ) { return -1;}
	if ( (!$a['image']) && $b[image] ) { return 1;}
  return 0 - strcmp( $a['updated_at'], $b['updated_at']);
}

function log_info($txt, $headline = ""){
  $colored_string .= "\033[" .  ($headline?'1;36':'1;35') . "m";
  echo $colored_string . $txt. "\033[0m" . "\n";
}

function log_error($txt){
  $colored_string .= "\033[" .  '1;31' . "m";
  echo $colored_string . '## ' . $txt. "\033[0m" . "\n";
}


$config = parse_ini_file('_config.ini');
echo "\n  Using github organisation name from config:\n  " . $config['organisation_name'];


class UpdateData {

	/**
	 * method to access the github api without getting blocked (you need to set user agent)
	 */
	private function getData($url) {

		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  curl_setopt($ch, CURLOPT_USERAGENT,'CodeForDeGithubReader');
		$data = curl_exec($ch);

    if(!$data) {
      echo "\nbroken response: \n";
      die($data);
    }

		curl_close($ch);
		return $data;
	}


  /**
   * Download a file to a url
   */
  private function downloadUrlToFile($url, $file, $updateTime)
  {
    $isThere = file_exists($file);
    $updatedDaysAgo = (time() - filemtime($file)) / (24*60*60) ;
    # log_info("$file is " . ($updatedDaysAgo) . " days old. (vs. $updateTime)" );

    if ((!$isThere) ||
      ($isThere && ($updatedDaysAgo > $updateTime ))
    ) {
      log_info("File not there or too old: Re-downloading " . $file);
      $repoString = $this->getData($url);
      file_put_contents($file, $repoString);
    } else {

      # check if a broken file was downloaded, and redownload
      $issueData = file_get_contents($file);
		  $issues = json_decode( $issueData, true );

      if (isset($issues['message']) && strpos( $issues['message'], 'rate limit exceeded')) {
        log_info('File seems to be broken! Re-downloading ' . $file);
        $repoString = $this->getData($url);
        file_put_contents($file, $repoString);
      }

    }

  }

  /**
   * Main function that downloads all the stuff and updates the meta data
   */
	public function run( $config, $update = 0, $upateOnly = '')
  {

    log_info("STARTING.. " );
    log_info("param 1 (re-download all github metadata files that are older than x days? enter '-1' to re-download anyways) = " . ($update ? $update  . ' days' : "don't re-download any files"));
    log_info("param 2 (update only this project) = " . ($upateOnly ?: "all"));
    log_info("");


    $apiCred = '&client_id='.$config['client_id'].'&client_secret='.$config['client_secret'];
    log_info("Using credentials: " . $apiCred);

    $githubOrg = $config['organisation_name'];
    $hideRepos  = [

      'WhatsMyDistrict' => 1
    ];


		# update all the basic json files
    $this->downloadUrlToFile(
      "https://api.github.com/orgs/$githubOrg/members?per_page=100" . $apiCred,
	     "json/members.json",
       $update
    );
    $this->downloadUrlToFile(
      "https://api.github.com/orgs/$githubOrg/repos?per_page=100&sort=pushed&direction=desc" . $apiCred,
	     "json/repos.json",
       $update
    );
		$repoString = file_get_contents( "json/repos.json" );
		$repos = json_decode( $repoString, true );


    # download all the repo meta data
		$allRepos = [];
		foreach ( $repos AS $repo ) {

      $repoName = $repo['name'];

      if ($hideRepos[$repoName] || preg_match('/obsolet/i', $repo['description']) ) {
        log_info("Skipping repository " . $repoName);
        continue;
      }

		  log_info( "\Reading repository ==============================> " . $repoName, 'hl');

		  // get issue information
		  if ((!$upateOnly)||($upateOnly &&($upateOnly==$repoName) ) ) {
        sleep(1);
		    $this->downloadUrlToFile(
          "https://api.github.com/repos/$githubOrg/$repoName/issues?state=all" . $apiCred,
		      "json/repos/".$repoName."_issues.json",
          $update
        );
		  }
	    $issueData = file_get_contents("json/repos/".$repoName."_issues.json");
		  $issues = json_decode( $issueData, true );

      if (isset($issues['message']) && $issues['message']) {
        log_error('GITHUB API PROBLEM?');
        print_r($issues);
        die();
      }


		  // get users infos from issues
		  $users = [];
		  $closed = 0;
		  $total = 0;
		  foreach ( $issues AS $issue ) {
        if (!$issue["user"]) {
          echo "\nBROKEN IssUE";
          print_r($issue);
          die();
        } else {
  		    $issueUser = $issue["user"]["login"];
  		    $users[$issueUser]['count']++;
  		    $users[$issueUser]['name']        = $issueUser;
  		    $users[$issueUser]["avatar_url"]  = $issue["user"]["avatar_url"];
  		    $users[$issueUser]["html_url"]    = $issue["user"]["html_url"];
        }

		    if ($issue['state']=="closed") {
		      $closed++;
		    }
		    $total++;
		  }
		  usort( $users, "userCmp");


		  // get infos from readme.md
		  $readme="";
		  if ($update && ((!$upateOnly)||($upateOnly &&($upateOnly==$repoName) ) ) ) {
        $this->downloadUrlToFile(
          'https://raw.githubusercontent.com/'.$githubOrg.'/'.$repoName.'/master/README.md',
		      "json/repos/".$repoName."_readme.md",
          $update
        );
		  }
		  $readme = file_get_contents("json/repos/".$repoName."_readme.md");

      $image = "";
		  #if ( preg_match( '/\[[^\]+]\]\((htt[^\)]+png)\)/ims', $readme, $matches ) ) {
		  if ( preg_match( '/\[([^\]]+)\]\((htt[^\)]+(?:png|jpg))/ims', $readme, $matches ) ) {
        $imagetext =$matches[1];
        $image = $matches[2];
		    if (preg_match('/build/i',$imagetext) ) {
          $image ="";
        }
        if (preg_match('/waffle/i',$image) ) {
          $image ="";
        }
      }
		  if ($image) {
		    echo "- $image\n";
		  }

      $metaData = [];
			if ( preg_match('/---\n((?:[a-z]+:\s*.+\n)+)---/im', $readme, $matches) ) {
				foreach( explode("\n", $matches[1] ) as $row) {
					$crap = explode(":", $row );
					$name = array_shift($crap);
					if ($name ) {
						$metaData[$name]=join(":", $crap);
            $metaData[$name] = preg_replace('/^\s+/','',$metaData[$name]);
					}
				}
        log_info("Metadata in README.md found:");
        print_r($metaData);
			}

			$title = preg_replace("/[^a-z0-9]+/i"," ",$repoName);
      $url = $repo['homepage'] ? $repo['homepage'] : ( $metaData['uri'] ? $metaData['uri'] : $metaData['url'] );
      if ( $url && (substr( strtolower($url), 0, 4) != "http" )) {
          $url = 'http://'.$url;
      }

      $screenshot_file = "";
      if ( $url &&!$image) {
        $screenshot_file = "screenshots/$repoName.jpg";

        if (!file_exists($screenshot_file)) {
          echo "- creating screenshot: $url => screenshots/$repoName.jpg\n";
          $create=`phantomjs update-screenshot.js $url screenshots-large/$repoName.png`;
          log_error("- command output: $create");
          $some=`convert screenshots-large/$repoName.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 $screenshot_file`;

        } else {

          echo "- screenshot already there.\n";
        }
        if(file_exists($screenshot_file)) { $image = $screenshot_file;}
      } elseif ($image) {
        echo "- found screenshot in README: $image\n";
      } else {
        log_error("- no image in readme, no url to take a screenshot from = no screenshot.");
      }

      $allRepos[$repoName]=[
		      'updated_at'    => $repo['updated_at'],
		      'created_at'    => $repo['created_at'],
		      'description'   => $repo['description'],
		      'name'          => $repoName,
					'title'         => $title,
		      'total_tasks'   => $total,
		      'closed_tasks'  => $closed,
		      'users'         => $users,
		      'image'         => $image,
					'html_url'			=> $repo['html_url'],
					'url' 				  => $url,
					'forum' 			  => $metaData['forum'],
          'status'        => $metaData['status'],
          'meta'          => $metaData
		  ];
      #print_r($allRepos[$repoName]);

		}

		usort( $allRepos, 'repoSort' );

		file_put_contents(
		  "json/repos_meta.json",
		  json_encode( $allRepos )
		);

    log_info("writing meta-file: " . "json/repos_meta.json");
    log_info("DONE!");

	}

}

if (!isset($argv[1])) {
  die('

  Usage: php update-data.php [daysInThePast] [updateOnlyThisProject]

    [daysInThePast] = Download only repositories, that have local cache files older than [daysInThePast] days
                      E.g. "14" to download only repository data that is older than 14 days
                           "-1" to download all the repsitories new

    [updateOnlyThisProject] = Can be the name of a single project, to update only the metadata for one project

  ');
}

$class = new UpdateData;
$class->run( $config, $argv[1], $argv[2] );
