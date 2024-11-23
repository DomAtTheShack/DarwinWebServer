// JavaScript function to handle form submission and input validation
function parseFCC(event) {
    // Prevent default form submission
    event.preventDefault();

    // Get the callsigns from the textarea
    let callsignsText = document.getElementById("callsigns").value.toUpperCase();

    // Update the textarea with the cleaned value
    document.getElementById("callsigns").value = callsignsText;

    // Split the cleaned text into individual callsigns (one per line)
    let callsignsArray = callsignsText.split('\n').map(line => line.trim()).filter(Boolean);

    // Clear previous results
    let resultDiv = document.querySelector('.result-list');

    // Show results and hide the form
    if (callsignsArray.length === 0) {
        alert("Please enter at least one valid callsign.");
        return;
    }

    document.querySelector('form').style.display = 'none';
    resultDiv.innerHTML = ""; // Clear previous results

    // Check each callsign asynchronously
    callsignsArray.forEach(callsign => {
        checkCallsign(callsign);
    });

    // Ensure back button is visible
    document.querySelector('.back-button').style.display = 'block';
}

// Prevent users from typing spaces or special characters in the textarea
document.getElementById("callsigns").addEventListener("input", function(event) {
    event.target.value = event.target.value.replace(/[^a-zA-Z0-9\n]/g, ""); // Allow new lines
});

function goBack() {
    document.querySelector('form').style.display = 'block'; // Show the input form
    document.querySelector('.result-list').innerHTML = ""; // Clear the results
    document.querySelector('.back-button').style.display = 'none'; // Hide back button
    document.getElementById("callsigns").value = ""; // Optionally clear the textarea
}

function checkCallsign(callsign) {
    const url = `https://callook.info/index.php?callsign=${callsign}&display=json`;

    httpGetAsync(url, function(responseText) {
        let resultDiv = document.querySelector('.result-list');
        let jsonResponse;

        try {
            jsonResponse = JSON.parse(responseText);
        } catch (error) {
            console.error("Failed to parse response:", error);
            let errorElement = document.createElement('div');
            errorElement.className = 'error-item';
            errorElement.innerHTML = `<strong>Error:</strong> Could not retrieve data for ${callsign}.`;
            resultDiv.appendChild(errorElement);
            return;
        }

        let resultElement = document.createElement('div');
        resultElement.className = 'result-item';

        resultElement.innerHTML = `<strong>Callsign:</strong> ${callsign} <br> 
                                   <strong>Class:</strong> ${jsonResponse.current ? (jsonResponse.current.operClass) : "N/A"} <br>
                                   <strong>Status:</strong> ${jsonResponse.status || "N/A"} <br>
                                   <strong>Type:</strong> ${jsonResponse.type || "N/A"} <br>
                                   <strong>Name:</strong> ${jsonResponse.name || "N/A"} <br>
                                   <strong>Address:</strong> ${jsonResponse.address ? (jsonResponse.address.line1 + ", " + jsonResponse.address.line2) : "N/A"} <br>
                                   <strong>FRN:</strong> ${jsonResponse.otherInfo ? (jsonResponse.otherInfo.frn) : "N/A"} <br>
                                   <strong>Expiration:</strong> ${jsonResponse.otherInfo ? (jsonResponse.otherInfo.expiryDate) : "N/A"} <br>
                                   <strong>License Grant:</strong> ${jsonResponse.otherInfo ? (jsonResponse.otherInfo.grantDate) : "N/A"} <br>
                                   <strong>Last Updated:</strong> ${jsonResponse.otherInfo ? (jsonResponse.otherInfo.lastActionDate) : "N/A"} <br>
                                   <strong>GridSquare:</strong> ${jsonResponse.location ? (jsonResponse.location.gridsquare) : "N/A"} <br>`;

        resultDiv.appendChild(resultElement);
    });
}

function httpGetAsync(theUrl, callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState === 4) {
            if (xmlHttp.status === 200) {
                callback(xmlHttp.responseText);
            } else {
                console.error("HTTP request failed with status:", xmlHttp.status);
                let resultDiv = document.querySelector('.result-list');
                let errorElement = document.createElement('div');
                errorElement.className = 'error-item';
                errorElement.innerHTML = `<strong>Error:</strong> Unable to fetch data from server (status: ${xmlHttp.status}).`;
                resultDiv.appendChild(errorElement);
            }
        }
    };
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}
