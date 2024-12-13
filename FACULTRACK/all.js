document.addEventListener("DOMContentLoaded", function () {
    const facultyForm = document.getElementById("faculty-details");

    // File input preview logic
    document.querySelectorAll(".file-input").forEach(input => {
        input.addEventListener("change", function (event) {
            const preview = this.nextElementSibling;
            preview.innerHTML = ""; // Clear previous preview
            const file = event.target.files[0];

            if (file) {
                const fileName = document.createElement("p");
                fileName.textContent = `Uploaded file: ${file.name}`;
                preview.appendChild(fileName);

                const fileURL = URL.createObjectURL(file);
                if (file.type.startsWith("image/")) {
                    const img = document.createElement("img");
                    img.src = fileURL;
                    preview.appendChild(img);
                } else if (file.type === "application/pdf") {
                    const iframe = document.createElement("iframe");
                    iframe.src = fileURL;
                    iframe.width = "100%";
                    iframe.height = "200px";
                    preview.appendChild(iframe);
                } else {
                    const link = document.createElement("a");
                    link.href = fileURL;
                    link.target = "_blank";
                    link.textContent = "Click to view uploaded file";
                    preview.appendChild(link);
                }
            }
        });
    });

    // Form submission logic
    facultyForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const facultyName = document.getElementById("faculty-name").value;
        const designation = document.getElementById("designation").value;
        const department = document.getElementById("department").value;

        console.log("Faculty Name:", facultyName);
        console.log("Designation:", designation);
        console.log("Department:", department);

        alert("Faculty details submitted successfully!");
    });

    // Function to calculate total grade points
    function calculateTotal() {
        let totalGradePoints1 = 0;
        let totalGradePoints2 = 0;
        let totalGradePoints3 = 0;

        // Helper function to calculate section totals
        function calculateTableTotal(tableId, totalGradePointId) {
            const table = document.querySelector(tableId);
            const rows = table.querySelectorAll("tbody tr");
            let sectionTotal = 0;

            rows.forEach(row => {
                const gradingInput = row.querySelector(".grading-input");
                const gradePointCell = row.querySelector(".grade-point");

                if (gradingInput && gradePointCell) {
                    const grade = parseFloat(gradingInput.value) || 0;
                    const weight = parseFloat(gradingInput.getAttribute("data-weight")) || 0;
                    const gradePoint = grade * weight;
                    gradePointCell.textContent = gradePoint.toFixed(2);
                    sectionTotal += gradePoint;
                }
            });

            document.getElementById(totalGradePointId).textContent = sectionTotal.toFixed(2);
            return sectionTotal;
        }

        totalGradePoints1 = calculateTableTotal("#evaluation-table", "total-grade-point1");
        totalGradePoints2 = calculateTableTotal("#research-table", "total-grade-point2");
        totalGradePoints3 = calculateTableTotal("#hod-table", "total-grade-point3");

        const grandTotal = totalGradePoints1 + totalGradePoints2 + totalGradePoints3;
        document.getElementById("grand-total").textContent = grandTotal.toFixed(2);
    }

    // Attach event listeners to inputs to recalculate totals on change
    document.querySelectorAll(".grading-input").forEach(input => {
        input.addEventListener("input", calculateTotal);
    });

    // Initial total calculation on page load
    window.addEventListener("load", calculateTotal);

    // Function to calculate allowance and grade
    function calculateAllowance() {
        const academics = parseInt(document.getElementById("academics").value) || 0;
        const research = parseInt(document.getElementById("research").value) || 0;
        const administrative = parseInt(document.getElementById("administrative").value) || 0;
        const hod = parseInt(document.getElementById("hod").value) || 0;
        const enteredDriveLink = document.getElementById("drive-link").value || "No link provided";

        const totalScore = academics + research + administrative + hod;
        let allowance = "No allowance";
        let grade = "A";

        if (totalScore >= 200) {
            allowance = "\u20B95,000";
            grade = "A+++";
        } else if (totalScore >= 160) {
            allowance = "\u20B93,500";
            grade = "A++";
        } else if (totalScore >= 120) {
            allowance = "\u20B92,000";
            grade = "A+";
        }

        document.getElementById("result").innerHTML = `
            <p><strong>Total Score:</strong> ${totalScore}</p>
            <p><strong>Grade:</strong> ${grade}</p>
            <p><strong>Performance Allowance:</strong> ${allowance}</p>
            <p><strong>Entered Drive Link:</strong> ${enteredDriveLink}</p>
        `;

        // Send data to the PHP server
        const formData = new FormData();
        formData.append("totalScore", totalScore);
        formData.append("grade", grade);
        formData.append("allowance", allowance);
        formData.append("driveLink", enteredDriveLink);

        fetch("store_database.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Data stored successfully!");
                } else {
                    alert(`Error storing data: ${data.message}`);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error sending data to the server.");
            });

        return {
            totalScore,
            grade,
            allowance,
            driveLink: enteredDriveLink
        };
    }

    // Event listener for "submit-form" button
    // Event listener for "submit-form" button
    document.getElementById("submit-form").addEventListener("click", function () {
        // Call your custom calculateAllowance function if applicable
        if (typeof calculateAllowance === "function") {
            const { totalScore, grade, allowance, driveLink } = calculateAllowance();
            console.log("Calculated values:", { totalScore, grade, allowance, driveLink });
        } else {
            console.warn("calculateAllowance function is not defined.");
        }
    
        // Select the content to  be exported
        const content = document.querySelector(".container");
    
        if (!content) {
            console.error("Content container not found.");
            alert("Error: Content for PDF generation not found.");
            return;
        }
    
        // Optional: Adjust content styling for PDF output
        content.style.width = "auto"; // Ensure proper scaling
    
        // PDF generation options
        const options = {
            margin: 10, // Adjust margin as needed
            filename: "Performance_Evaluation_Form.pdf",
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 2 }, // Scale factor for better quality
            jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
        };
    
        // Prevent duplicate downloads by disabling the button temporarily
        const submitButton = document.getElementById("submit-form");
        submitButton.disabled = true;
    
        // Generate and download the PDF
        html2pdf()
            .from(content)
            .set(options)
            .save()
            .then(() => {
                alert("PDF downloaded successfully! The form will now reset.");
                const facultyForm = document.querySelector("form"); // Ensure form exists
                if (facultyForm) {
                    facultyForm.reset(); // Reset form after successful download
                }
                // Re-enable the button after a brief delay
                setTimeout(() => {
                    submitButton.disabled = false;
                }, 1000); // Adjust delay if necessary
            })
            .catch(error => {
                console.error("Error generating PDF:", error);
                alert("An error occurred while generating the PDF. Please try again.");
                // Re-enable the button if there was an error
                submitButton.disabled = false;
            });
    });
    
});
