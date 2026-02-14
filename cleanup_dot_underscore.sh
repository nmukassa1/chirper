#!/bin/bash

# Script to remove all macOS ._ files from the current directory and subdirectories

echo "Searching for ._ files..."

# Find all ._ files and count them
count=$(find . -name "._*" -type f | wc -l | tr -d ' ')

if [ "$count" -eq 0 ]; then
    echo "No ._ files found. Nothing to clean up."
    exit 0
fi

echo "Found $count ._ file(s)."
echo ""
echo "Files to be removed:"
find . -name "._*" -type f

echo ""
read -p "Do you want to remove these files? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    # Remove all ._ files
    find . -name "._*" -type f -delete
    echo "✓ Successfully removed $count ._ file(s)."
else
    echo "Cancelled. No files were removed."
fi
