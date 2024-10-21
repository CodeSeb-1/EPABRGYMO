function toggleAddressInput() {
    const manualAddressInput = document.getElementById("manualPurokInput");
    const otherAddress = document.getElementById("otherPurok");
    const purokOption = document.querySelector(
      'input[name="purokOption"]:checked'
    ).value;
  
    if (purokOption === "manual") {
      manualAddressInput.style.display = "block";
      otherAddress.setAttribute("required", "required"); // Make manual address required
    } else {
      manualAddressInput.style.display = "none";
      otherAddress.removeAttribute("required"); // Remove required from manual address
    }
  }
  