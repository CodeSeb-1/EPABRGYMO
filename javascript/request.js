function toggleRequestor() {
  const meRequestor = document.getElementById("meRequestor");
  const otherRequestorDetails = document.getElementById(
    "otherRequestorDetails"
  );
  const otherName = document.getElementById("otherName");
  const otherBirthday = document.getElementById("otherBirthday");
  const otherAddress = document.getElementById("otherAddress");
  const requestorType = document.querySelector(
    'input[name="requestor"]:checked'
  ).value;

  if (requestorType === "me") {
    meRequestor.style.display = "block";
    otherRequestorDetails.style.display = "none";

    // Remove required attribute for "Other" fields
    otherName.removeAttribute("required");
    otherBirthday.removeAttribute("required");
    otherAddress.removeAttribute("required");
  } else {
    meRequestor.style.display = "none";
    otherRequestorDetails.style.display = "block";

    // Add required attribute for "Other" fields
    otherName.setAttribute("required", "required");
    otherBirthday.setAttribute("required", "required");

    // Check if the address input is visible
    toggleAddressInput();
  }
}

function toggleAddressInput() {
  const manualAddressInput = document.getElementById("manualAddressInput");
  const otherAddress = document.getElementById("otherAddress");
  const addressOption = document.querySelector(
    'input[name="addressOption"]:checked'
  ).value;

  if (addressOption === "manual") {
    manualAddressInput.style.display = "block";
    otherAddress.setAttribute("required", "required"); // Make manual address required
  } else {
    manualAddressInput.style.display = "none";
    otherAddress.removeAttribute("required"); // Remove required from manual address
  }
}

