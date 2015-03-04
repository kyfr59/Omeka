// Attention : lancer le cron tous les heures passées de 58 minutes

/*
/!\ Ensure avoid access to this .js file in tour Apache configuration :
<Files ~ "cron.js$">
	Deny from all
</Files>
*/
var backoffice = 'http://localhost';
var username = 'admin';
var password = 'passss';

// Define the admin page & connexion parameters
var page = require('webpage').create(),
    url =  backoffice + '/admin/users/login',
    data = 'username=' + username + '&password=' + password; 

// Connect to OMEKA backoffice
page.open(url, 'post', data, function (status) { 

	if (status !== 'success') {

	    console.log('Unable to connect to OMEKA backoffice.');

	} else {
	    
	    // Call the list of jobs page (JSON)
	    var page = require('webpage').create();
		page.open(backoffice + '/admin/oaipmh-harvester/index/view', function (status) {

			if (status !== 'success') {

		    	console.log('Unable to connect to list of jobs page.');	

		    } else {

		    	 // Parse JSON results
			    var jsonSource = page.plainText;
			    var resultObject = JSON.parse(jsonSource);

			    if (resultObject.length > 0 ) {

					now = new Date();
					var day = now.getDay(); // Current day of the week (0 for 'sunday', 1 for 'monday', etc.)
					var hour = now.getHours() + 1; // Current strict hour rounded to upper hour
			    	var i = 0;

				    for(var r in resultObject) {

				    	if (resultObject[r].day == day && resultObject[r].hour == hour) {
		    	
		    				// Define the harvest page & parameters
					        var url = backoffice + '/admin/oaipmh-harvester/index/harvest';
							var data = 'base_url=' + resultObject[r].base_url + '&metadata_spec=oai_dc';

							page.open(url, 'post', data, function (status) { // Call the harvest page

						        if (status !== 'success') {
						        	console.log('Unable ton call the harvest page');

						    	} else {
									console.log("ok");
						    		page.render('harvest.png'); // DEBUG
						        }
					    	});
					    	i++;
				    	}
				    }

				    console.log("Harvest finished : " + i + " repository harvested");

			    } else {

			    	console.log("Nothing to harvest");
			    	phantom.exit();	
			    }
			}
		});
	}
});




