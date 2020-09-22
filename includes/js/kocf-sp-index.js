( function( $ ) {

    $( document ).ready( function() {

        $( '#kocf-sp-form-submit' ).on( 'click', function( event ) {
            event.preventDefault();
            event.stopPropagation();

            console.log('#kocf-sp-form-submit clicked');

            $('#kocf-sp-form-submit').prop('disabled', true);

            // remove all the old errors
            $('.kocf-error-span').removeClass('kocf-show-error');
            $('.kocf-error-span').html('');
            $('#kocf-sp-error-wrapper').removeClass("kocf-show-error-wrapper");
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
              // console.log(pair[0], pair[1]);
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
              $('#kocf-sp-email-address-error').html('Please enter an email ID.');
              $('#kocf-sp-email-address-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Email Address');
            }
            if(!kocfSignUpObj.kocfSpDiscordName) {
              $('#kocf-sp-discord-name-error').html('Please enter a discord name.');
              $('#kocf-sp-discord-name-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Discord Name');
            }
            if(!kocfSignUpObj.kocfSpGameMode) {
              $('#kocf-sp-game-mode-error').html('Please select atleast one game mode.');
              $('#kocf-sp-game-mode-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Game Mode');
            }
            if(!kocfSignUpObj.kocfSpTimeZone) {
              $('#kocf-sp-time-zone-error').html('Please select a time zone.');
              $('#kocf-sp-time-zone-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Time zone');
            }
            if(!kocfSignUpObj.kocfSpDiscordServer) {
              $('#kocf-sp-discord-server-error').html('Please select at least one.');
              $('#kocf-sp-discord-server-error').addClass('kocf-show-error');
              kocfSpFormErrors.push('Discord Server');
            }

            if(kocfSpFormErrors.length >= 1) {
              // show which fields have error
              $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'>Please update the following field/s</span>" );
              for(var i=0; i < kocfSpFormErrors.length; i++) {
                $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'> - " + kocfSpFormErrors[i] + "</span>" );
              }
              $('#kocf-sp-error-wrapper').addClass("kocf-show-error-wrapper");
              $('#koc-sp-form-submit').prop('disabled', false);
            } else {
              // make API call here
              var data = {
                  'action' : 'kocf_handle_ajax',
                  'form_type': 'signup',
                  'signup_data': kocfSignUpObj
              };
              $.post( kocfhAjax.ajaxurl, data, function( response ) {
                  $('#koc-sp-form-submit').prop('disabled', true);
                  if (response && response.success == true ) {
                    // hide form and show success message
                    $('#kocf-sign-up-form').hide();
                    $('#kocf-sp-success ').show();
                  } else {
                    // show error message
                    $('#kocf-sp-error-wrapper').append( "<span class='kocf-show-error'> - " + response.data + "</span>" );
                    $('#kocf-sp-error-wrapper').addClass("kocf-show-error-wrapper");
                    $('#koc-sp-form-submit').prop('disabled', false);
                  }
              } );
            }
        });

        $( '#kocf-rs-submit' ).on( 'click', function( event ) {
          event.preventDefault();
          event.stopPropagation();

          $('#kocf-rs-submit').prop('disabled', true);

          // remove all the old errors
          $('.kocf-error-span').removeClass('kocf-show-error');
          $('.kocf-error-span').html('');
          $('#kocf-rs-error-wrapper').removeClass("kocf-show-error-wrapper");
          $('#kocf-rs-error-wrapper').html('');

          var kocfRsWinnerVal = $('select[name ="kocfRsWinner"]').val();
          var kocfRsWinner;
          if(kocfRsWinnerVal) {
            var krwvSplitArr = kocfRsWinnerVal.split('kuid_');
            kocfRsWinner = krwvSplitArr[krwvSplitArr.length - 1];
          }

          var kocfRsPlayer2Val = $('select[name ="kocfRsPlayer2"]').val();
          var kocfRsPlayer2;
          if(kocfRsPlayer2Val) {
            var krp2vSplitArr = kocfRsPlayer2Val.split('kuid_');
            kocfRsPlayer2 = krp2vSplitArr[krp2vSplitArr.length - 1];
          }

          var kocfRsPlayer3Val = $('select[name ="kocfRsPlayer3"]').val();
          var kocfRsPlayer3 = null;
          if(kocfRsPlayer3Val) {
            console.log({ kocfRsPlayer3Val });
            var krp3vSplitArr = kocfRsPlayer3Val.split('kuid_');
            kocfRsPlayer3 = krp3vSplitArr[krp3vSplitArr.length - 1];
          }

          var kocfRsPlayer4Val = $('select[name ="kocfRsPlayer4"]').val();
          var kocfRsPlayer4 = null;
          if(kocfRsPlayer4Val) {
            var krp4vSplitArr = kocfRsPlayer4Val.split('kuid_');
            kocfRsPlayer4 = krp4vSplitArr[krp4vSplitArr.length - 1];
          }

          var kocfRsOtherPlayers = $('input[name="kocfRsOtherPlayers"]').val();
          var kocfRsGameForCrown = $('input[name="kocfRsGameForCrown"]:checked').val();
          var kocfRsGameMode = $('input[name="kocfRsGameMode"]:checked').val();
          var kocfRsGameScenario = $('input[name="kocfRsGameScenario"]:checked').val();

          var kocfResultsStepOneError = [];

          if(!kocfRsWinner) {
            $('#kocf-rs-winner-error').html('Please select a winner.')
            $('#kocf-rs-winner-error').addClass('kocf-show-error');
            kocfResultsStepOneError.push('Please select a winner.');
          }
          if(!kocfRsPlayer2) {
            $('#kocf-rs-player2-error').html('Please select Player 2.')
            $('#kocf-rs-player2-error').addClass('kocf-show-error');
            kocfResultsStepOneError.push('Please select Player 2.');
          }
          if(kocfRsWinner) {
            if(kocfRsWinner === kocfRsPlayer2) {
              kocfResultsStepOneError.push("Winner and Player 2 can't be the same user.");
            }
            if(kocfRsWinner === kocfRsPlayer3) {
              kocfResultsStepOneError.push("Winner and Player 3 can't be the same user.");
            }
            if(kocfRsWinner === kocfRsPlayer4) {
              kocfResultsStepOneError.push("Winner and Player 4 can't be the same user.");
            }
          }
          if(kocfRsPlayer2) {
            if(kocfRsPlayer2 === kocfRsPlayer3) {
              kocfResultsStepOneError.push("Player 2 and Player 3 can't be the same user.");
            }
            if(kocfRsPlayer2 === kocfRsPlayer4) {
              kocfResultsStepOneError.push("Player 2 and Player 4 can't be the same user.");
            }
          }
          if(kocfRsPlayer3) {
            if(kocfRsPlayer3 === kocfRsPlayer4) {
              kocfResultsStepOneError.push("Player 3 and Player 4 can't be the same user.");
            }
          }

          if(!kocfRsGameForCrown) {
            $('#kocf-rs-game-for-crown-error').html('Please select at least one.')
            $('#kocf-rs-game-for-crown-error').addClass('kocf-show-error');
            kocfResultsStepOneError.push('Game for the Crown');
          }
          if(!kocfRsGameMode) {
            $('#kocf-rs-game-mode-error').html('Please select at least one.')
            $('#kocf-rs-game-mode-error').addClass('kocf-show-error');
            kocfResultsStepOneError.push('Game mode');
          }
          if(!kocfRsGameScenario) {
            $('#kocf-rs-game-scenario-error').html('Please select at least one.')
            $('#kocf-rs-game-scenario-error').addClass('kocf-show-error');
            kocfResultsStepOneError.push('Game Scenario');
          }

          if(kocfResultsStepOneError.length > 0) {
            // show error if required fields are empty
            $('#kocf-rs-error-wrapper').append( "<span class='kocf-show-error'>Please update the following field/s</span>" );
            for(var i=0; i < kocfResultsStepOneError.length; i++) {
              $('#kocf-rs-error-wrapper').append( "<span class='kocf-show-error'> - " + kocfResultsStepOneError[i] + "</span>" );
            }
            $('#kocf-rs-error-wrapper').addClass("kocf-show-error-wrapper");
            $('#kocf-rs-submit').prop('disabled', false);
          } else {
            var kocfResultsObj = {
              kocfRsWinner,
              kocfRsPlayer2,
              kocfRsPlayer3: kocfRsPlayer3,
              kocfRsPlayer4: kocfRsPlayer4,
              kocfRsOtherPlayers: kocfRsOtherPlayers ? kocfRsOtherPlayers : null,
              kocfRsGameForCrown,
              kocfRsGameMode,
              kocfRsGameScenario,
            }
            // make API call here
            var data = {
                'action' : 'kocf_handle_ajax',
                'form_type': 'results',
                'results_data': kocfResultsObj
            };
            $.post( kocfhAjax.ajaxurl, data, function( response ) {
                $('#kocf-rs-submit').prop('disabled', true);
                if (response && response.success == true ) {
                  // hide form and show success message
                  $('#kocf-results-form').hide();
                  $('#kocf-rs-success ').show();
                } else {
                  // show error message
                  $('#kocf-rs-error-wrapper').append( "<span class='kocf-show-error'> - " + response.data + "</span>" );
                  $('#kocf-rs-error-wrapper').addClass("kocf-show-error-wrapper");
                  $('#kocf-rs-submit').prop('disabled', false);
                }
            } );
          }
        });

    });

})( jQuery );
