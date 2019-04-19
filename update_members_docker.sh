#!/bin/bash
docker run --name update_members --rm -it -e GITHUBTOKEN= -v "$PWD"/json/members.json:/app/json/members.json update-members

