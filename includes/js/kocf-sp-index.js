( function( $ ) {

    $( document ).ready( function() {

        $( '#koc-sp-form-submit' ).on( 'click', function( event ) {

            event.preventDefault();
            event.stopPropagation();

            $('#koc-sp-form-submit').prop('disabled', true);

            // remove all the old errors
            $('.kocf-error-span').removeClass('kocf-show-error');
            $('.kocf-error-span').html('');
            $('#kocf-sp-error-wrapper').removeClass("kocf-sp-show-error-wrapper");
            $('#kocf-sp-error-wrapper').html('');

            // variable to store errors & values
            var kocfSpFormErrors = [];
            var kocfSignUpObj = {
              kocfSpEmailAddress: null,
              kocfSpCatanUniverseName: null,
              kocfSpColonistName: null,
              kocfSpCatanVrName: null,
              kocfSpDiscordName: null,
              kocfSpGameMode: null,
              kocfSpDiscordServer: null,
              kocfSpTimeZone: null,
              kocfSpNewsletter: 0,
            };

            // get values from the form and store it in kocfSignUpObj
            var myForm = document.getElementById('kocf-sign-up-form');
            var formData = new FormData(myForm);
            for(var pair of formData.entries()) {
              console.log(pair[0], pair[1]);
              if(pair[0] && pair[1]) {
                if ( pair[0] === 'kocfSpGameMode' ) {
                  if(!kocfSignUpObj.kocfSpGameMode) {
                    kocfSignUpObj.kocfSpGameMode = pair[1];
                  } else {
                    kocfSignUpObj.kocfSpGameMode += (', ' + pair[1]);
                  }
                } else if( pair[0] === 'kocfSpDiscordServer' ) {
                  if( pair[1] === 'Both' ) {
                    kocfSignUpObj.kocfSpDiscordServer = 'King of Catan (Catan Universe & Colonist.io), World Series of Catan-server (CatanVR)';
                  } else {
                    kocfSignUpObj.kocfSpDiscordServer = pair[1];
                  }
                } else if (pair[0] === 'kocfSpNewsletter') {
                  kocfSignUpObj.kocfSpNewsletter = 1;
                } else {
                  kocfSignUpObj[pair[0]] = pair[1];
                }
              }
            }

            // show error if required fields are empty
            if(!kocfSignUpObj.kocfSpEmailAddress) {
              $('#kocf-sp-email-address-error').html('Please enter an email ID.')
              $('#kocf-sp-email-address-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Email Address');
            }
            if(!kocfSignUpObj.kocfSpDiscordName) {
              $('#kocf-sp-discord-name-error').html('Please enter a discord name.')
              $('#kocf-sp-discord-name-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Discord Name');
            }
            if(!kocfSignUpObj.kocfSpGameMode) {
              $('#kocf-sp-game-mode-error').html('Please select atleast one game mode.')
              $('#kocf-sp-game-mode-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Game Mode');
            }
            if(!kocfSignUpObj.kocfSpTimeZone) {
              $('#kocf-sp-time-zone-error').html('Please select a time zone.')
              $('#kocf-sp-time-zone-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Time zone');
            }

            if(kocfSpFormErrors.length >= 1) {
              // show which fields have error
              $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'>Please update the following field/s</span>" );
              for(var i=0; i < kocfSpFormErrors.length; i++) {
                $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'> - " + kocfSpFormErrors[i] + "</span>" );
              }
              $('#kocf-sp-error-wrapper').addClass("kocf-sp-show-error-wrapper");
              $('#koc-sp-form-submit').prop('disabled', false);
            } else {
              // make API call here
              var data = {
                  'action' : 'kocf_handle_ajax',
                  'form_type': 'signup',
                  'signup_data': kocfSignUpObj
              };
              $.post( kocfhAjax.ajaxurl, data, function( response ) {
                  $('#koc-sp-form-submit').prop('disabled', false);
                  if (response && response.success == true ) {
                    // hide form and show success message
                    $('#kocf-sign-up-form').hide();
                    $('#kocf-sp-success ').show();
                  } else {
                    // show error message
                    $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'> - " + response.data + "</span>" );
                    $('#kocf-sp-error-wrapper').addClass("kocf-sp-show-error-wrapper");
                  }
              } );
            }
        })

    });

})( jQuery );
