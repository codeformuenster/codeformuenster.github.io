#!/bin/bash
docker run --name update_members -it -e GITHUBTOKEN= update-members
docker cp update_members:/app .
docker rm update_members
mkdir -p json
cp app/members.json json/members.json
rm -rf app
