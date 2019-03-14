import requests
import json
import sys
import os


githubToken = os.environ['GITHUBTOKEN']
#githubToken = ""
githubOrganization = "codeformuenster"
userJSONOutputFile = "json/members.json"

def getUsers(cursor, userarray):
  query = """
  {
    organization(login: \"""" + githubOrganization + """\") {
      members(first: 100""" + ((", after: \""  + cursor + "\") {") if cursor != "" else ") {") + """
        totalCount
        edges {
          cursor
          node {
            avatarUrl
            login
            url
            name
          }
        }
      }
    }
  }
  """
  headers = { 'Content-Type': 'application/json', 'Authorization': 'bearer ' + githubToken }
  payload = { 'query': query}
  r = requests.post("https://api.github.com/graphql", data=json.dumps(payload), headers=headers)
  data = r.json()
  users = data["data"]["organization"]["members"]["edges"]


  for user in users:
      user = user["node"]
      print( "Reading user ==============================> " + user["name"]);
      userarray.append({
        "avatar_url": user["avatarUrl"],
        "login": user["login"],
        "html_url": user["url"],
        "name": user["name"]
        })
  cursor = ""
  if len(users) == 100:
    cursor = users[-1]["cursor"]
  return cursor




if(githubToken == "") :
  print("No Token!")
  sys.exit()

# Users
print("Fetching all users from " + githubOrganization)

userdata = []
lastCursor = getUsers("", userdata)
while lastCursor != "":
  lastCursor = getUsers(lastCursor, userdata)


print("Finished fetching data from GitHub.")

print("Writing data to " + userJSONOutputFile + " file...")
with open(userJSONOutputFile, 'w') as outfile:
    json.dump(userdata, outfile, indent=4)
print("Finished writing data to " + userJSONOutputFile + " file.")
