    document.addEventListener("DOMContentLoaded", function() {
    loadHTML('header', 'header.html');
    loadHTML('footer', 'footer.html');
});

    // Function to load HTML content into a specified element
    function loadHTML(elementId, filePath) {
    fetch(filePath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading HTML:', error));
}
