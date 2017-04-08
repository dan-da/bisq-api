# NOTE: bitsquare must be running, with api listening on port 8080.

nc -z 127.0.0.1 8080
if [ $? -ne 0 ]
then
	echo "bitsquare must be running, with api listening on port 8080"
	exit 1
fi


INI=/tmp/.php.ini
echo "extension=json.so" > $INI
./vendor/nette/tester/Tester/tester -p `which php` -c $INI --stop-on-fail
rm -f $INI
