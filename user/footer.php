<script>
    // Dropdown list
const dropDownHeads = document.querySelectorAll(".dropdown-head");
dropDownHeads.forEach((dropDownHead) => {
    dropDownHead.addEventListener("click", () => {
        let dropDownList = dropDownHead.nextElementSibling;

        if (dropDownList.style.maxHeight) {
            dropDownList.style.maxHeight = null;
            dropDownList.style.padding = "0";
        } else {
            dropDownList.style.maxHeight = dropDownList.scrollHeight + "px";
            if (dropDownList.parentElement.parentElement)
                dropDownList.parentElement.parentElement.style.maxHeight = "max-content";
        }
    });
});
</script>
</body>
</html>