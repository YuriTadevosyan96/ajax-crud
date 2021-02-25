$(document).ready(function () {
    let allExistingUsers = [];

    $.get("../../app/logic.php?check_connection=true", function (data, status) {
        if (data) {
            console.log("Database created successfully");
            getUsers();
        }
    });

    function getUsers() {
        $.get("../../app/logic.php?get_users=true", function (data, status) {
            data = JSON.parse(data);
            allExistingUsers = data;
            if (data.length) {
                let content = "";
                data.forEach((user, index) => {
                    content += `<tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>${user.NAME}</td>
                                    <td>${user.EMAIL}</td>
                                    <td>${user.PROFESSION || ""}</td>
                                    <td>${user.AGE || ""}</td>
                                    <td>
                                        <button type="button" data-user-id="${
                                            user.ID
                                        }" class="edit-item-btn btn btn-info btn-sm mb-1">Редактировать</button>
                                        <button type="button" data-user-id="${
                                            user.ID
                                        }" class="delete-item-btn btn btn-danger btn-sm mb-1">Удалить</button>
                                    </td>
                                </tr>`;
                    $("#mainContent").html(content);
                });

                $(".edit-item-btn").click(function () {
                    $("#create_or_edit").val("edit");
                    fillForm($(this).data("userId"));
                });

                $(".delete-item-btn").click(function () {
                    const deleteId = $(this).data("userId");
                    if (confirm("Удалить без возможности восстановления?")) {
                        $.ajax({
                            url: `../../app/logic.php?id=${deleteId}`,
                            type: "DELETE",
                            success: function (data) {
                                console.log(data);
                                getUsers();
                            },
                        });
                    }
                });
            } else {
                $("#mainContent").html(`
                            <tr>
                                <td colspan="6" class="text-center">
                                    Нет данных для отображения
                                </td>
                            </tr>`);
            }
        });
    }

    $("#submitForm").on("submit", function (e) {
        e.preventDefault();
        const createOrEdit = $("#create_or_edit").val();
        function request(method) {
            $.ajax({
                url: "../../app/logic.php",
                data: $("#submitForm").serialize(),
                type: method,
                success: function (data) {
                    console.log(data);
                    $("#addEditUserForm").modal("hide");
                    emptyFormFields();
                    getUsers();
                },
            });
        }

        if (createOrEdit == "create") {
            request("POST");
        }

        if (createOrEdit == "edit") {
            request("PUT");
        }
    });

    $("#addItem").on("click", () => {
        $("#create_or_edit").val("create");
    });

    $(".btn-close").on("click", () => {
        emptyFormFields();
    });

    function emptyFormFields() {
        Array.from(document.forms.submitForm.elements).forEach((input) => {
            input.value = "";
        });
    }

    function fillForm(id) {
        const record = allExistingUsers.find((item) => item.ID == id);
        $("#name").val(record.NAME);
        $("#email").val(record.EMAIL);
        $("#profession").val(record.PROFESSION);
        $("#age").val(record.AGE);
        $("#edit_item_id").val(id);
        $("#addEditUserForm").modal("show");
    }
});
