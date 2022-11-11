"use strict";

// Class Definition
var KTLogin = (function () {
  var _login;

  var _showForm = function (form) {
    var cls = "login-" + form + "-on";
    var form = "kt_login_" + form + "_form";

    _login.removeClass("login-forgot-on");
    _login.removeClass("login-signin-on");
    _login.removeClass("login-signup-on");

    _login.addClass(cls);

    KTUtil.animateClass(
      KTUtil.getById(form),
      "animate__animated animate__backInUp"
    );
  };

  var _handleSignInForm = function () {
    var validation;

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validation = FormValidation.formValidation(
      KTUtil.getById("kt_login_signin_form"),
      {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: "Username is required",
              },
            },
          },
          password: {
            validators: {
              notEmpty: {
                message: "Password is required",
              },
            },
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          submitButton: new FormValidation.plugins.SubmitButton(),
          //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
          bootstrap: new FormValidation.plugins.Bootstrap(),
        },
      }
    );

    $("#kt_login_signin_submit").on("click", function (e) {
      e.preventDefault();
      var form = KTUtil.getById("kt_login_signin_form");
      var formSubmitUrl = KTUtil.attr(form, "action");
      var formSubmitButton = KTUtil.getById("kt_login_signin_submit");

      validation.validate().then(function (status) {
        if (status == "Valid") {
          FormValidation.utils
            .fetch(formSubmitUrl, {
              method: "POST",
              dataType: "json",
              params: {
                username: form.querySelector('[name="username"]').value,
                password: form.querySelector('[name="password"]').value,
              },
            })
            .then(function (response) {
              // Return valid JSON
              // Release button
              KTUtil.btnRelease(formSubmitButton);
              console.log(response);
              if (response.error == false) {
                // Swal.fire({
                //   text: "All is cool! Now you submit this form",
                //   icon: "success",
                //   buttonsStyling: false,
                //   confirmButtonText: "Ok, got it!",
                //   customClass: {
                //     confirmButton: "btn font-weight-bold btn-light-primary",
                //   },
                // }).then(function () {
                //   KTUtil.scrollTop();
                // });
                window.location.reload();
                // window.location();
              } else {
                Swal.fire({
                  text: response.message,
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "Ok, got it!",
                  customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                  },
                }).then(function () {
                  KTUtil.scrollTop();
                });
              }
            });

          // swal
          //   .fire({
          //     text: "All is cool! Now you submit this form",
          //     icon: "success",
          //     buttonsStyling: false,
          //     confirmButtonText: "Ok, got it!",
          //     customClass: {
          //       confirmButton: "btn font-weight-bold btn-light-primary",
          //     },
          //   })
          //   .then(function () {
          //     KTUtil.scrollTop();
          //   });
        } else {
          swal
            .fire({
              text:
                "Maaf. sepertinya terjadi kesalahan, harap periksa email dan password ",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              KTUtil.scrollTop();
            });
        }
      });
    });

    // Handle forgot button
    $("#kt_login_forgot").on("click", function (e) {
      e.preventDefault();
      _showForm("forgot");
    });

    // Handle signup
    $("#kt_login_signup").on("click", function (e) {
      e.preventDefault();
      _showForm("signup");
    });
  };

  var _handleSignUpForm = function (e) {
    var validation;
    var form = KTUtil.getById("kt_login_signup_form");

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validation = FormValidation.formValidation(form, {
      fields: {
        fullname: {
          validators: {
            notEmpty: {
              message: "Username is required",
            },
          },
        },
        email: {
          validators: {
            notEmpty: {
              message: "Email address is required",
            },
            emailAddress: {
              message: "The value is not a valid email address",
            },
          },
        },
        password: {
          validators: {
            notEmpty: {
              message: "The password is required",
            },
          },
        },
        cpassword: {
          validators: {
            notEmpty: {
              message: "The password confirmation is required",
            },
            identical: {
              compare: function () {
                return form.querySelector('[name="password"]').value;
              },
              message: "The password and its confirm are not the same",
            },
          },
        },
        agree: {
          validators: {
            notEmpty: {
              message: "You must accept the terms and conditions",
            },
          },
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap(),
      },
    });

    $("#kt_login_signup_submit").on("click", function (e) {
      e.preventDefault();

      validation.validate().then(function (status) {
        if (status == "Valid") {
          swal
            .fire({
              text: "All is cool! Now you submit this form",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              KTUtil.scrollTop();
            });
        } else {
          swal
            .fire({
              text:
                "Sorry, looks like there are some errors detected, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              KTUtil.scrollTop();
            });
        }
      });
    });

    // Handle cancel button
    $("#kt_login_signup_cancel").on("click", function (e) {
      e.preventDefault();

      _showForm("signin");
    });
  };

  var _handleForgotForm = function (e) {
    var validation;

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validation = FormValidation.formValidation(
      KTUtil.getById("kt_login_forgot_form"),
      {
        fields: {
          email: {
            validators: {
              notEmpty: {
                message: "Email address is required",
              },
              emailAddress: {
                message: "The value is not a valid email address",
              },
            },
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap: new FormValidation.plugins.Bootstrap(),
        },
      }
    );

    // Handle submit button
    $("#kt_login_forgot_submit").on("click", function (e) {
      e.preventDefault();
      var form = KTUtil.getById("kt_login_forgot_form");
      var formForgotUrl = KTUtil.attr(form, "action");
      var formForgottButton = KTUtil.getById("kt_login_forgot_submit");

      validation.validate().then(function (status) {
        if (status == "Valid") {
          // Submit form
          // KTUtil.scrollTop();
          FormValidation.utils
            .fetch(formForgotUrl, {
              method: "POST",
              dataType: "json",
              params: {
                username: form.querySelector('[name="username_forgot"]').value,
              },
            })
            .then(function (response) {
              // Return valid JSON
              // Release button
              KTUtil.btnRelease(formForgottButton);
              console.log(response);
              if (response.error == false) {
                Swal.fire({
                  text: response.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Please check email!",
                  customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                  },
                }).then(function () {
                  KTUtil.scrollTop();
                });
                // window.location.reload();
                // window.location();
              } else {
                Swal.fire({
                  text: response.message,
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "Ok!",
                  customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                  },
                }).then(function () {
                  KTUtil.scrollTop();
                });
              }
            });
        } else {
          swal
            .fire({
              text:
                "Sorry, looks like there are some errors detected, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              KTUtil.scrollTop();
            });
        }
      });
    });

    // Handle cancel button
    $("#kt_login_forgot_cancel").on("click", function (e) {
      e.preventDefault();

      _showForm("signin");
    });
  };

  // Public Functions
  return {
    // public functions
    init: function () {
      _login = $("#kt_login");

      _handleSignInForm();
      _handleSignUpForm();
      _handleForgotForm();
    },
  };
})();

// Class Initialization
jQuery(document).ready(function () {
  KTLogin.init();
});
