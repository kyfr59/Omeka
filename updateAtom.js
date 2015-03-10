// Attention : lancer le cron tous les heures passées de 58 minutes

/*
/!\ Ensure avoid access to this .js file in tour Apache configuration :
<Files ~ "updateAtom.js$">
	Deny from all
</Files>
*/


var backoffice 	= 'http://localhost';
var email 		= 'kyfr59@gmail.com';
var password 	= 'passss';
var next 		= 'http://localhost/atom/';
var omekaRoot	= '/home/franck/sites/omeka/';  

// Retrieve command line arguments 
var args = require('system').args;
var addDigitalObjectUrl = args[1]; // Url to add a digital object in ATOM (like http://localhost/atom/index.php/b9wet/addDigitalObject)
var objectToAdd 		= args[2]; // The URL of the object to add in ATOM

console.log("cocou");
// TODO : add control on args

// Define the admin page & connexion parameters
var page = require('webpage').create(),
    url =  backoffice + '/atom/index.php/user/login',
    data = 'email=' + email + '&password=' + password + '&next=' + next; 

// Connect to ATOM backoffice
page.open(url, 'post', data, function (status) { 

	if (status !== 'success') {

	    console.log('Unable to connect to ATOM backoffice.');

	} else {
	    
	    // page.render(omekaRoot + 'atom.png'); // DEBUG
	    // phantom.exit();	
			    
	    // Prepare parameters for adding digital object
	    var page = require('webpage').create();
	    
		// Call the "add digital object" page with parameters
	    page.open(addDigitalObjectUrl, 'post', 'url=' + objectToAdd, function (status) { 

			if (status !== 'success') {

		    	console.log('Unable to connect to list of jobs page.');	

		    } else {

				page.render(omekaRoot + 'add.png'); // DEBUG
			    phantom.exit();	

			}
		});
	}
});




