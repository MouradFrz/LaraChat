const inputField = $("#user-search");
const displayDiv = $("#floating-users");
displayDiv.hide();
inputField.on("keydown", () => {
    if (inputField.val().length > 1) {
        axios
            .get(`/search-user?keyword=${inputField.val()}`)
            .then((res) => res.data)
            .then((res) => {
                displayDiv.empty();
                if (res.length) {
                    res.forEach((element) => {
                        displayDiv.append(
                            `<a href="new-convo/${element.id}">${element.email}</a>`
                        );
                    });
                } else {
                    displayDiv.append(
                        `<p>No results found!</p>`
                    );
                }
            });
        displayDiv.show();
    } else {
        displayDiv.hide();
    }
});

inputField.on("blur", () => {
    if (inputField.val() === "") {
        displayDiv.hide();
    }
});
