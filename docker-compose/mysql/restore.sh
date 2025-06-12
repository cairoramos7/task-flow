#!/bin/bash

# List .sql files in the current directory
sql_files=(*.sql)

# Check if there are any .sql files in the folder
if [ ${#sql_files[@]} -eq 0 ]; then
  echo "No .sql files found in the current folder."
  exit 1
fi

# Display the list of available .sql files
echo "Available .sql files:"
for i in "${!sql_files[@]}"; do
  echo "[$i] ${sql_files[$i]}"
done

# Prompt the user to choose a file by number
read -p "Select a file by number: " file_index

# Check if the choice is valid
if ! [[ "$file_index" =~ ^[0-9]+$ ]] || [ "$file_index" -ge "${#sql_files[@]}" ]; then
  echo "Invalid choice. Exiting."
  exit 1
fi

# Get the selected file
selected_file=${sql_files[$file_index]}

# Command to restore the database
docker exec -i f4f-mysql /usr/bin/mysql -u root --password=secret faith4funds < "$selected_file"

# Confirmation message
if [ $? -eq 0 ]; then
  echo "Successfully restored from $selected_file"
else
  echo "Failed to restore the database"
fi
