$(function () {

    $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function ($form, event, errors) {},
        submitSuccess: function ($form, event) {
            event.preventDefault();
            
            $this = $("#sendMessageButton");
            $this.prop("disabled", true);

            $.ajax({
                url: "/ajax/sendmsg",
                type: "POST",
                data: {
                    name: $("input#name").val(),
                    email_from: $("input#email").val(),
                    user_to: $("#user_to").val(),
                    subject: $("input#subject").val(),
                    message: $("textarea#message").val()
                },
                cache: false,
                success: function (r) {
                    if(r.errors) var msg = r.errors;
                    if(r.success) var msg = r.success;
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').append("<strong>"+msg+"</strong>");
                    $('#success > .alert-success').append('</div>');
                    $('#contactForm').trigger("reset");
                },
                error: function () {
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').append($("<strong>").text("Sorry, it seems that our mail server is not responding. Please try again later!"));
                    $('#success > .alert-danger').append('</div>');
                    $('#contactForm').trigger("reset");
                },
                complete: function () {
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
        filter: function () {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
});

$('#name').focus(function () {
    $('#success').html('');
});
