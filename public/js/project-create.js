var selectElement = $("#year-select");
var url = "";

$(document).ready(function () {
    var currentstep = 0;
    var setcount = 0;
    $("#objectiveInput-error").hide();
    $("#addObjectiveSet-btn").click(function () {
        $(
            "#form2"
        ).append(`<div class="container-fluid objectiveSetContainer mb-2 p-2" data-value="0">
                                    <div>
                                        <div class="input-group mb-2 objectiveName-input">

                                            <textarea class="form-control" aria-label="With textarea" name="objectiveName[]" placeholder="Write objective here.."></textarea>

                                            <input type="number" name="objectiveSetNumber[]" class="objectiveSetNumber d-none" value="0">
                                            <button type="button" class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="addObjective-btn btn btn-sm btn-green">
                                        <b class="small">Add Objective</b>
                                    </button>
                                    <button type="button" class="removeObjectiveSet-btn btn btn-sm btn-red px-5 d-block mx-auto">
                                        <b class="small">Remove Objective Set</b>
                                    </button>


                                </div>`);
    });
    $(document).on("click", ".addObjective-btn", function () {
        $(
            this
        ).prev().append(`<div class="input-group mb-2 objectiveName-input">

<textarea class="form-control" aria-label="With textarea" name="objectiveName[]" placeholder="Write objective here.."></textarea>

<input type="number" name="objectiveSetNumber[]" class="objectiveSetNumber d-none" value="0">
<button type="button" class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i class="bi bi-x-lg"></i></button>
</div>`);
    });
    $(document).on("click", ".removeObjectiveName-btn", function () {
        if ($(this).parent().parent().find(".objectiveName-input").length > 1) {
            $(this).parent().remove();
        }
    });
    $(document).on("click", ".removeObjectiveSet-btn", function () {
        if (
            $(this).parent().parent().find(".objectiveSetContainer").length > 1
        ) {
            $(this).parent().remove();
        }
    });

    $("#programtitle").on("keyup", function (e) {
        if ($("#programtitle").val() === "") {
            $(".programleaderdiv").css("display", "none");
        } else {
            $(".programleaderdiv").css("display", "inline-block");
        }
    });

    $(document).on("input", ".autocapital", function () {
        var inputValue = $(this).val();
        if (inputValue.length > 0) {
            $(this).val(
                inputValue.charAt(0).toUpperCase() + inputValue.slice(1)
            );
        }
    });

    $(document).on("click", "#toggleButton", function (event) {
        $(this).next().slideToggle("fast");
    });

    $(document).on("click", ".projectdiv", function (event) {
        event.preventDefault();
        var department = $(this).attr("data-dept");
        var projectid = $(this).attr("data-value");

        projecturl = projecturl.replace(":projectid", projectid);
        projecturl = projecturl.replace(
            ":department",
            encodeURIComponent(department)
        );

        window.location.href = projecturl;
    });

    // Add an event listener to the select element
    selectElement.change(function () {
        var selectedOption = $(this).find(":selected");
        var department = selectedOption.val();

        baseUrl = baseUrl.replace(
            ":department",
            encodeURIComponent(department)
        );

        window.location.href = baseUrl;
    });

    function updateButtons() {
        if (currentstep == 0) {
            $("#prevproject").hide();
            $("#nextproject").show();
            $("#createproject").hide();
            $("#tab1-tab").attr("disabled", true);
            $("#tab1-tab").tab("show");
        } else if (currentstep == 1) {
            $("#prevproject").show();
            $("#nextproject").hide();
            $("#createproject").show();
            $("#tab1-tab").removeAttr("disabled");
            $("#tab2-tab").tab("show");
        }
    }
    $("#tab1-tab").click((event) => {
        event.preventDefault();

        currentstep--;
        updateButtons();
    });
    $("#nextproject").click((event) => {
        event.preventDefault();

        var hasError = handleError();

        if (!hasError) {
            currentstep++;
            updateButtons();
        }
    });
    $("#prevproject").click((event) => {
        event.preventDefault();

        currentstep--;
        updateButtons();
    });

    $("#addproj").click((event) => {
        event.preventDefault();

        updateButtons();
        $("#newproject").modal("show");
    });

    $("#objectiveset").on("click", ".add-objective", function () {
        var setid = $(this).prev().find("div:first .objectivesetid").val();

        var $newInput = $(
            '<input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">'
        );
        var $newInput1 = $(
            '<input type="number" id="objectivesetid" name="objectivesetid[]" value="' +
                setid +
                '" class="objectivesetid d-none">'
        );

        var $newButton2 = $(
            '<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>'
        );
        var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append(
            $newInput,
            $newInput1,
            $newButton2
        );
        $(this).prev().append($newDiv);
    });
    $("#objform form").on("click", ".remove-objective", function () {
        $(this).parent().remove();
    });
    $("#objform form").on("click", ".edit-objective", function () {
        $(this).prev().focus();
    });
    $("#objform form").on("keydown", ".input-objective", function () {
        if (event.keyCode === 13) {
            event.preventDefault();

            $(this).blur();
        }
    });

    $("#addset").click((event) => {
        event.preventDefault();
        setcount++;
        var $newInput = $(
            '<input type="text" class="col-8 m-1 input-objective p-2 rounded autocapital" id="objective-input" name="projectobjective[]" placeholder="Enter objective">'
        );
        var $newInput1 = $(
            '<input type="number" id="objectivesetid" name="objectivesetid[]" value="' +
                setcount +
                '" class="objectivesetid d-none">'
        );
        var $newButton2 = $(
            '<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>'
        );
        var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append(
            $newInput,
            $newInput1,
            $newButton2
        );
        var $newDiv1 = $("<div>").append($newDiv);
        var $newButton3 = $(
            '<button type="button" class="add-objective btn btn-sm btn-outline-success" id="addobjective"><b class="small">Add Objective</b></button><hr>'
        );
        $("#objectiveset").append($newDiv1, $newButton3);
    });

    $("#createproject").click((event) => {
        event.preventDefault();

        var hasError = handleError();

        if (!hasError) {
            $(this).prop("disabled", true);
            var department = $("#department").val();

            projecturl = projecturl.replace(
                ":department",
                encodeURIComponent(department)
            );

            $("#objectiveindex").val(
                $('textarea[name="objectiveName[]"]').length
            );

            $("div.objectiveSetContainer").each(function (index) {
                $(this).attr("data-value", index);
            });

            $('textarea[name="objectiveName[]"]').each(function (index) {
                $(this).attr("name", "objectiveName[" + index + "]");
            });
            $('input[name="objectiveSetNumber[]"]').each(function (index) {
                var id = $(this).parent().parent().parent().attr("data-value");

                $(this).val(id);
                $(this).attr("name", "objectiveSetNumber[" + index + "]");
            });
            // Remove 'disabled' attribute from all disabled options
            $("#programleader option:disabled").prop("disabled", false);

            /**
                                var objectiveindex = $('input[name="projectobjective[]"]').length;

                                $('input[name="projectobjective[]"]').each(function(index) {
                                    $(this).attr('name', 'projectobjective[' + index + ']');

                                });

                                $('input[name="objectivesetid[]"]').each(function(index) {
                                    $(this).attr('name', 'objectivesetid[' + index + ']');

                                });


                                $('#objectiveindex').val(objectiveindex);
                */
            var dataurl = $("#form1").attr("data-url");
            var data1 = $("#form1").serialize();
            var data2 = $("#form2").serialize();

            // concatenate serialized data into a single string
            var formData = data1 + "&" + data2;
            $("#loadingSpan").css("display", "block");

            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: "POST",
                data: formData,
                success: function (response) {
                    var projectId = response.projectid;
                    projecturl = projecturl.replace(":projectid", projectId);
                    $("#loadingSpan").css("display", "none");

                    if (response.isMailSent == 0) {
                        $("#newproject").modal("hide");
                        $("#mailNotSent").modal("show");

                        // Set the initial countdown value
                        let countdownValue = 5;

                        // Function to update the countdown value and redirect
                        function updateCountdown() {
                            countdownValue -= 1;
                            $("#countdown").text(countdownValue);

                            if (countdownValue <= 0) {
                                // Redirect to your desired URL
                                window.location.href = projecturl; // Replace with your URL
                            } else {
                                // Call the function recursively after 1 second (1000 milliseconds)
                                setTimeout(updateCountdown, 1000);
                            }
                        }

                        // Start the countdown
                        updateCountdown();
                    } else {
                        window.location.href = projecturl;
                    }
                },
                error: function (xhr, status, error) {
                    //$('#createprojectError').text(xhr.responseText);
                    /*
                        $('#createprojectError').text("There is a problem with server. Contact Administrator!");
                        $('#loadingSpan').css('display', 'none');
                        */
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                },
            });
        }
    });

    function formatDate(inputDate) {
        // Split the inputDate by the '/' character
        var parts = inputDate.split("/");

        // Rearrange the parts into the "YYYY-MM-DD" format
        var formattedDate = parts[2] + "-" + parts[0] + "-" + parts[1];

        return formattedDate;
    }

    function handleError() {
        if (currentstep === 0) {
            var hasErrors = false;

            $(".invalid-feedback strong").text("");
            $(".is-invalid").removeClass("is-invalid");

            var projectTitle = $("#projecttitle").val();

            var projectLeader = $("#projectleader").val();

            //var programTitle = $('#programtitle').val();

            //var programLeader = $('#programleader').val();

            var projectStartDate = formatDate($("#projectstartdate").val());
            var projectEndDate = formatDate($("#projectenddate").val());

            // Validation for Project Title
            if (projectTitle.trim() === "") {
                $("#projecttitle").addClass("is-invalid");
                $("#projecttitle")
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Project Title is required.");
                hasErrors = true;
            }

            // Validation for Project Leader
            if (projectLeader.length === 0) {
                $(".projectleader").addClass("is-invalid");
                $(".projectleader")
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Project Leader is required.");
                hasErrors = true;
            }
            /**
                                // Validation for Program Title
                                if (programTitle.trim() === '') {
                                    $('#programtitle').addClass('is-invalid');
                                    $('#programtitle').next('.invalid-feedback').find('strong').text('Program Title is required.');
                                    hasErrors = true;
                                }


                if (programLeader.length === 0) {
                    $('.programleader').addClass('is-invalid');
                    $('.programleader').next('.invalid-feedback').find('strong').text('Program Leader is required.');
                    hasErrors = true;
                }
                */
            if ($("#projectstartdate").val() == "") {
                $("#projectstartdate").parent().addClass("is-invalid");
                $("#projectstartdate")
                    .parent()
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Project Start Date is required.");
                hasErrors = true;
            }
            if ($("#projectenddate").val() == "") {
                $("#projectenddate").parent().addClass("is-invalid");
                $("#projectenddate")
                    .parent()
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Project End Date is required.");
                hasErrors = true;
            }

            if (projectEndDate <= projectStartDate) {
                $("#projectenddate").parent().addClass("is-invalid");
                $("#projectenddate")
                    .parent()
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Project End Date must be after the Start Date.");
                hasErrors = true;
            }
            /*
                                // Validation for Project Start Date
                                if (projectStartDate.getFullYear() !== targetYear) {
                                    $('#projectstartdate').addClass('is-invalid');
                                    $('#projectstartdate').next('.invalid-feedback').find('strong').text('Project Start Date must be in ' + targetYear + '.');
                                    hasErrors = true;
                                }

                                // Validation for Project End Date
                                if (projectEndDate.getFullYear() !== targetYear || projectEndDate < projectStartDate) {
                                    $('#projectenddate').addClass('is-invalid');
                                    $('#projectenddate').next('.invalid-feedback').find('strong').text('Project End Date must be in ' + targetYear + ' and after the Start Date.');
                                    hasErrors = true;
                                }
                */
            return hasErrors;
        } else if (currentstep === 1) {
            var hasErrors = false;

            $('textarea[name="objectiveName[]"]').each(function (
                index,
                element
            ) {
                if ($(element).val() === "") {
                    $("#objectiveInput-error").show();
                    hasErrors = true;
                }
            });

            /*
                if ($('input[name="projectobjective[]"]').length === 0) {
                    $('.projectobjective-error strong').show();
                    hasErrors = true;
                } else {
                    $('input[name="projectobjective[]"]').each(function(index, element) {

                        if ($(element).val() === "") {
                            $('.projectobjective-error strong').show();
                            hasErrors = true;
                        }

                    });

                }*/
            return hasErrors;
        }
    }
});
