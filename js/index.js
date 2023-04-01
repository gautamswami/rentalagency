function togglePassword() {
  let passwordfield = document.getElementById("password");
  let togglebutton = document.getElementById("passwordtoggle");
  if (passwordfield.type === "password") {
    passwordfield.type = "text";
    togglebutton.textContent = "Hide";
    togglebutton.style.color = "#2c5162";
  } else {
    passwordfield.type = "password";
    togglebutton.textContent = "Show";
    togglebutton.style.color = "#76bedf";
  }
}
function handleAdd() {
  let form = document.getElementById("vehicle_form");
  if (form.style.display == "none") {
    form.style.display = "block";
  } else {
    form.style.display = "none";
  }
}
function editVehicle(data) {
  console.log(data,data.action,'dsa')
  if (data.action == "cancel") {
    document.getElementById("add_heading").textContent = "ADD VEHICLE";
    document.getElementById("add_button").textContent = "+ ADD";
    document.getElementById("cancel_button").style.display = "none";
    document.getElementById("model").value = "";
    document.getElementById("number").value = "";
    document.getElementById("seat").value = "";
    document.getElementById("rent").value = "";
  }
  else {
    document.getElementById("add_heading").textContent = "UPDATE VEHICLE";
    document.getElementById("add_button").textContent = "UPDATE";
    document.getElementById("cancel_button").style.display = "block";
    document.getElementById("add_button").value = data.id;
    document.getElementById("model").value = data.vehicle_model;
    document.getElementById("number").value = data.vehicle_number;
    document.getElementById("seat").value = data.vehicle_seats;
    document.getElementById("rent").value = data.vehicle_rent;
  }
}
