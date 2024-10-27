function toggleOtherpurpose(value) {
    const otherInput = document.getElementById("other_Purpose");
    const otherDiv = document.getElementById("otherPurpose");
    if (value === "others") {
      otherDiv.style.display = "block";
      otherInput.required = true;
    } else {
      otherDiv.style.display = "none";
      otherInput.required = false;
    }
  }