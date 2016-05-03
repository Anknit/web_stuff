1.) Lamp/Wamp server must be installed
2.) 

Pre-Requisites for installing a project on remote server:
	1.Lamp/Wamp server must be installed at port 3306
	2.xvfb must be installed on server
	3.apache server must own the www directly. If not run the command 'chown -R www-data:www-data /var/www'
	4.Complete code must be inside a container folder including Common, 'Project_Specific_Folder', 'temp', 'sampleInterfaces', index.php, install.php, installer.php
	5.This container folder has to be directly under the doc_root of the server (as like www/container_folder)


6. The www folder must be owned by apache user. The command for ubuntu machine could be like (chown -R www-data:www-data /var/www )
