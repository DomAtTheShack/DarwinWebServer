// Define the search function
function searchFiles() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase().replace(/\s/g, ''); // Remove spaces from the filter
    table = document.getElementById("fileTable");
    if (!table) return; // Exit if table is null
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            txtValue = txtValue.toUpperCase().replace(/\s/g, ''); // Remove spaces from the table content
            if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Attach the search function to the input event of the search input
document.getElementById("searchInput").addEventListener("input", searchFiles);

// Get the video path from the query parameter
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const videoPath = urlParams.get('video');
    console.log('Video path:', videoPath);

    // Set the video source
    if (videoPath) {
        const videoPlayer = document.getElementById('videoPlayer');
        videoPlayer.src = 'video.php?video=' + encodeURIComponent(videoPath);
    } else {
        console.error('Video path not provided.');
    }
});
