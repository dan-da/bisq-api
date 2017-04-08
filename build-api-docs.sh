cd apis
./build.sh

if [ $? -eq 0 ]
then
	echo "API Docs are in apis/index.html and apis/README.md"
else
	echo "An error occurred"
fi
