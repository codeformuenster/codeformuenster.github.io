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


$config = parse_ini_file('_config.ini');


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
	  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$data = curl_exec($ch);

    if(!$data) {
      echo "\nbroken response: \n";
      die($data);
    }

		curl_close($ch);
		return $data;
	}

	public function run( $config, $update = 0, $upateOnly = 'wo-ist-markt', $apiCred = '') {


# carparcsmuenster
    $apiCred = '&client_id='.$config['client_id'].'&client_secret='.$config['client_id'];
    $githubOrg = $config['organisation_name'];

    $hideRepos  = [
      'WhatsMyDistrict' => 1
    ];


		# update all the json files
		if ( $update ) {
      $mainUrl = "https://api.github.com/orgs/$githubOrg/members?per_page=100" . $apiCred;
  	  file_put_contents("json/members.json", $this->getData($mainUrl) );

		  $repoString = $this->getData("https://api.github.com/orgs/$githubOrg/repos?per_page=100&sort=pushed&direction=desc" . $apiCred);
		  file_put_contents("json/repos.json", $repoString);
		}

		if ( !$repoString) {
		  $repoString = file_get_contents( "json/repos.json" );
		}


		$repos = json_decode( $repoString, true );

		$allRepos = [];

		foreach ( $repos AS $repo ) {

      $repoName = $repo['name'];

      if ($hideRepos[$repoName] || preg_match('/obsolet/i', $repo['description']) ) {
        continue;
      }

		  echo "==============================>" . $repoName."\n";

		  // get issue information
		  $issueData = "";
		  if ($update && ((!$upateOnly)||($upateOnly &&($upateOnly==$repoName) ) ) ) {
		    $issueData = $this->getData("https://api.github.com/repos/$githubOrg/$repoName/issues?state=all" . $apiCred);
		    file_put_contents( "json/repos/".$repoName."_issues.json", $issueData );
		  }

		  if (!$issueData) {
		    $issueData = file_get_contents("json/repos/".$repoName."_issues.json");
		  }
		  $issues = json_decode( $issueData, true );


		  // get users infos from issues
		  $users = [];
		  $closed = 0;
		  $total = 0;
		  foreach ( $issues AS $issue ) {
        if (!$issue["user"]) {
          echo "\nBROKEN IssUE";
          print_r($issue);
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
		    $readme = $this->getData('https://raw.githubusercontent.com/'.$githubOrg.'/'.$repoName.'/master/README.md');
		    file_put_contents("json/repos/".$repoName."_readme.md", $readme );
		  }
		  if (!$readme) {
		    $readme = file_get_contents("json/repos/".$repoName."_readme.md");
		  }
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
          $some=`convert screenshots-large/$repoName.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 $screenshot_file`;

        } else {

          echo "-screenshot already there.\n";
        }
        if(file_exists($screenshot_file)) { $image = $screenshot_file;}
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
      print_r($allRepos[$repoName]);

		}

		usort( $allRepos, 'repoSort' );

		file_put_contents(
		  "json/repos_meta.json",
		  json_encode( $allRepos )
		);
	}

}

$class = new UpdateData;
$class->run( $config, $argv[1] );
