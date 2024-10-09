function showContent(tab) {
    document.getElementById('tab1').classList.remove('active');
    document.getElementById('tab2').classList.remove('active');
    document.getElementById('radio-bands').style.display = 'none';
    document.getElementById('morse-code').style.display = 'none';

    if (tab === 1) {
        document.getElementById('tab1').classList.add('active');
        document.getElementById('radio-bands').style.display = 'block';
    } else {
        document.getElementById('tab2').classList.add('active');
        document.getElementById('morse-code').style.display = 'block';
    }
}

// Fetching the client's coordinates and time information
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        document.getElementById('coordinates').textContent = `Coordinates: ${lat.toFixed(4)}, ${lon.toFixed(4)}`;

        // Calculate grid square
        const gridSquare = calculateGridSquare(lat, lon);
        document.getElementById('grid-square').textContent = `Grid Square: ${gridSquare}`;

        // Display local and UTC time
        const localTime = new Date();
        const utcTime = new Date(localTime.getTime() + localTime.getTimezoneOffset() * 60000); // Convert to UTC time

        document.getElementById('time').textContent = `Local Time: ${localTime.toLocaleTimeString()}, UTC Time: ${utcTime.toLocaleTimeString()}`;
    });
} else {
    document.getElementById('coordinates').textContent = "Geolocation not supported by your browser.";
}


// Grid square calculation (basic Maidenhead grid locator)
function calculateGridSquare(lat, lon) {
    const upperCase = "ABCDEFGHIJKLMNOPQRSTUVWX";
    const lowerCase = "abcdefghijklmnopqrstuvwx";

    const latAdj = lat + 90;
    const lonAdj = lon + 180;

    const latSquare = Math.floor(latAdj / 10);
    const lonSquare = Math.floor(lonAdj / 20);

    const latRemainder = latAdj % 10;
    const lonRemainder = lonAdj % 20;

    const gridSquare = upperCase[lonSquare] + upperCase[latSquare] +
        Math.floor(lonRemainder / 2) + Math.floor(latRemainder) +
        lowerCase[Math.floor((lonRemainder % 2) * 12)] +
        lowerCase[Math.floor((latRemainder % 1) * 24)];

    return gridSquare;
}


function showContent(tab) {
    const tab1 = document.getElementById('tab1');
    const tab2 = document.getElementById('tab2');
    const tab3 = document.getElementById('tab3');
    const tab4 = document.getElementById('tab4');
    const radioBands = document.getElementById('radio-bands');
    const morseCode = document.getElementById('morse-code');
    const morseDecode = document.getElementById('morse-code-decode');
    const qcode = document.getElementById('qCodes');


    tab1.classList.remove('active');
    tab2.classList.remove('active');
    tab3.classList.remove('active');
    tab4.classList.remove('active');

    radioBands.style.display = 'none';
    morseCode.style.display = 'none';
    morseDecode.style.display = 'none';
    qcode.style.display = 'none';

    if (tab === 1) {
        tab1.classList.add('active');
        radioBands.style.display = 'block';
    } else if (tab === 2) {
        tab2.classList.add('active');
        morseCode.style.display = 'block';
    } else if (tab === 3) {
        tab3.classList.add('active');
        morseDecode.style.display = 'block';
    }else {
        tab4.classList.add('active');
        qcode.style.display = 'block';
    }
}



