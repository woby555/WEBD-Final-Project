// Function to sort the table by column index
function sortTable(columnIndex) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("skills-table");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("tr");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

// Function to sort the table by class name
function sortTableByClass(className) {
    var table, rows, i;
    table = document.getElementById("skills-table");
    rows = table.getElementsByTagName("tr");

    // Loop through all table rows except the header
    for (i = 1; i < rows.length; i++) {
        var classCell = rows[i].getElementsByTagName("td")[1]; // Second column (class name)
        var currentClass = classCell.innerText.toLowerCase().trim();

        // Hide rows that don't match the selected class
        if (currentClass !== className.toLowerCase().trim()) {
            rows[i].style.display = "none";
        } else {
            rows[i].style.display = ""; // Show rows that match the selected class
        }
    }
}

function clearSort() {
    var table, rows, i;
    table = document.getElementById("skills-table");
    rows = table.getElementsByTagName("tr");

    // Loop through all table rows except the header
    for (i = 1; i < rows.length; i++) {
        rows[i].style.display = ""; // Show all rows
    }
}



