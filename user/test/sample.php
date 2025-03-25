<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .error { color: red; font-size: 14px; display: block; }
    </style>
    <script>
    function toggleVaccineForm() {
        var status = document.getElementById("vaccine_status").value;
        document.getElementById("vaccine_section").style.display = (status === "Vaccinated") ? "block" : "none";
    }

    function addVaccine() {
        let div = document.createElement("div");
        div.classList.add("vaccine_entry", "border", "p-3", "mb-2", "rounded");
        div.innerHTML = `
            <div class="mb-2">
                <label class="form-label">Vaccine Type</label>
                <input type="text" name="vaccine_type[]" class="form-control">
                <span class="error"></span>
            </div>
            <div class="mb-2">
                <label class="form-label">Vaccine Name</label>
                <input type="text" name="vaccine_name[]" class="form-control">
                <span class="error"></span>
            </div>
            <div class="mb-2">
                <label class="form-label">Vaccine Date</label>
                <input type="date" name="vaccine_date[]" class="form-control">
                <span class="error"></span>
            </div>
            <div class="mb-2">
                <label class="form-label">Administered By</label>
                <input type="text" name="administered_by[]" class="form-control">
                <span class="error"></span>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeVaccine(this)">Remove</button>
        `;
        document.getElementById("vaccine_entries").appendChild(div);
    }

    function removeVaccine(button) {
        button.parentElement.remove();
    }

    function validateForm(event) {
        event.preventDefault(); // Prevent form submission
        let isValid = true;
        let form = document.forms["petForm"];
        let fields = ["name", "phone", "email", "address", "pet_name", "pet_age", "pet_type", "pet_breed", "pet_info", "pet_image"];
        
        fields.forEach(field => {
            let input = form[field];
            let errorSpan = input.closest("div").querySelector(".error");
            if (input.value.trim() === "") {
                errorSpan.textContent = "This field is required.";
                isValid = false;
            } else {
                errorSpan.textContent = "";
            }
        });

        let phone = form["phone"].value.trim();
        let email = form["email"].value.trim();
        let petAge = form["pet_age"].value.trim();
        
        if (phone !== "" && !/^\d+$/.test(phone)) {
            form["phone"].closest("div").querySelector(".error").textContent = "Phone number must be numeric.";
            isValid = false;
        }

        if (email !== "" && !/^\S+@\S+\.\S+$/.test(email)) {
            form["email"].closest("div").querySelector(".error").textContent = "Enter a valid email address.";
            isValid = false;
        }

        if (petAge !== "" && (isNaN(petAge) || petAge <= 0)) {
            form["pet_age"].closest("div").querySelector(".error").textContent = "Pet age must be a positive number.";
            isValid = false;
        }

        let vaccineStatus = document.getElementById("vaccine_status").value;
        let vaccineEntries = document.querySelectorAll(".vaccine_entry");

        if (vaccineStatus === "Vaccinated" && vaccineEntries.length === 0) {
            alert("Please enter at least one vaccine.");
            isValid = false;
        }

        if (vaccineStatus === "Vaccinated") {
            vaccineEntries.forEach(entry => {
                entry.querySelectorAll("input").forEach(input => {
                    let errorSpan = input.closest("div").querySelector(".error");
                    if (input.value.trim() === "") {
                        errorSpan.textContent = "This field is required.";
                        isValid = false;
                    } else {
                        errorSpan.textContent = "";
                    }
                });
            });
        }

        if (isValid) {
            form.submit(); // Submit if validation passes
        }
    }
    </script>
</head>
<body class="container mt-5">
    <h2 class="text-center mb-4">Add Pet</h2>
    <form name="petForm" action="save_pet.php" method="post" enctype="multipart/form-data" onsubmit="validateForm(event)">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Name</label>
            <input type="text" name="pet_name" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Age</label>
            <input type="text" name="pet_age" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Type</label>
            <input type="text" name="pet_type" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Breed</label>
            <input type="text" name="pet_breed" class="form-control"> 
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Info</label>
            <textarea name="pet_info" class="form-control"></textarea>
            <span class="error"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Image</label>
            <input type="file" name="pet_image" class="form-control">
            <span class="error"></span>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Vaccine Status</label>
            <select name="vaccine_status" id="vaccine_status" class="form-select" onchange="toggleVaccineForm()">
                <option value="Not Vaccinated">Not Vaccinated</option>
                <option value="Vaccinated">Vaccinated</option>
            </select>
        </div>
        
        <div id="vaccine_section" class="mb-3" style="display:none;">
            <label class="form-label">Vaccine Details</label>
            <div id="vaccine_entries"></div>
            <button type="button" class="btn btn-primary mt-2" onclick="addVaccine()">Add Vaccine</button>
        </div>
        
        <button type="submit" class="btn btn-success w-100">Submit</button>
    </form>
</body>
</html>


