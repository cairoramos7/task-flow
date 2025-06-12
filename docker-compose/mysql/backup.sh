#!/bin/bash

docker exec f4f-mysql /usr/bin/mysqldump -u root --password=secret faith4funds > backup_$(date +"%Y-%m-%d_%H-%M-%S").sql
