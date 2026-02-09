function toggleFields(checkboxId, fieldsId) {
  const checkbox = document.getElementById(checkboxId);
  const fields = document.getElementById(fieldsId);

  checkbox.addEventListener("change", () => {
    fields.style.display = checkbox.checked ? "block" : "none";
  });
}

toggleFields("logo", "logoFields");
toggleFields("cards", "cardsFields");
toggleFields("social", "socialFields");