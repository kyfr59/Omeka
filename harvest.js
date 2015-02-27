//
//	Javascript script that automates the harvest of a repository in OMEKA
// 
// 	You need a PhantomJS instance installed on your server (http://phantomjs.org)
// 	Call the script with the --cookies-file param (to store persistents cookies), for example :
// 	phantomjs --cookies-file=cookies.txt harvest.js
//  
// 	@author Franck Dupont <kyfr59@gmail.com>
//


var page = require('webpage').create(),
    url = 'http://localhost/admin/users/login',
    data = 'username=admin&password=passss';

page.open(url, 'post', data, function (status) { // Login on OMEKA backoffice

    if (status !== 'success') {

        console.log('Unable to post!');

    } else {
        
        // page.render('connexion.png'); // DEBUG
        var url = 'http://localhost/admin/oaipmh-harvester/index/harvest';
		var data = 'base_url=http://localhost/atom/index.php/;oai?verb=ListRecords&metadata_spec=oai_dc';

		page.open(url, 'post', data, function (status) { // Call the harvest page

	        if (status !== 'success') {
	        	console.log('Unable to post!');

	    	} else {

	    		// page.render('harvest.png'); // DEBUG
	        }
        	phantom.exit();
    	});
    }
});

