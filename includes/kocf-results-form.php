<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

// this function returns the signup form
function kocf_show_results_form_code($atts) {
  global $wpdb;

  $signup_table_name = $wpdb->prefix . KOCF_SIGNUP_TABLE;
  $users = $wpdb->get_results( "SELECT user_id, user_email_id FROM $signup_table_name ORDER BY user_email_id" );

  ?>
  <form name="kocf-results-form" id="kocf-results-form">
    <div id="kocf-results-form-step1">
      <div class="kocf-col-wrapper">
        <label class="kocf-labels" for="kocfRsWinner">Who won the game?<sup class="kocf-required">*</sup></label>
        <select name="kocfRsWinner" class="kocf-select-box" required>
          <option value="">Select Winner</option>
          <?php foreach ($users as $row){ ?>
            <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
          <?php } ?>
        </select>
  			<span id="kocf-rs-winner-error" class="kocf-error-span"></span>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels">Who were the other participating players?</label>
        <p class="kocf-note">(Please include all players)</p>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels" for="kocfRsPlayer2">Player 2<sup class="kocf-required">*</sup></label>
        <select name="kocfRsPlayer2" class="kocf-select-box" required>
          <option value="">Select Player 2</option>
          <?php foreach ($users as $row){ ?>
            <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
          <?php } ?>
        </select>
  			<span id="kocf-rs-player2-error" class="kocf-error-span"></span>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels" for="kocfRsPlayer3">Player 3</label>
        <select name="kocfRsPlayer3" class="kocf-select-box">
          <option value="">Select Player 3</option>
          <?php foreach ($users as $row){ ?>
            <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels" for="kocfRsPlayer4">Player 4</label>
        <select name="kocfRsPlayer4" class="kocf-select-box">
          <option value="">Select Player 4</option>
          <?php foreach ($users as $row){ ?>
            <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels" for="kocfRsOtherPlayers">Other player(s) not in the list</label>
  	    <input type="text" name="kocfRsOtherPlayers" class="kocf-input-box" />
      </div>
      <!-- <div class="kocf-col-wrapper">
        <button class="kocf-buttons" id="kocf-rs-next">Next</button>
      </div> -->
    </div>
    <div id="kocf-results-form-step2">
      <div class="kocf-col-wrapper">
        <label class="kocf-labels">Was it a Game for the Crown?<sup class="kocf-required">*</sup></label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameForCrown" value="Yes"> Yes
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameForCrown" value="No"> No
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameForCrown" value="CatanVR Crown"> CatanVR Crown
        </label>
        <span id="kocf-rs-game-for-crown-error" class="kocf-error-span"></span>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels">What Game Mode was played?<sup class="kocf-required">*</sup></label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Base Game (suggested)"> Base Game (suggested)
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Base Game + Seafarers"> Base Game + Seafarers
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Base Game + Cities & Knights"> Base Game + Cities & Knights
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Base + Seafarers + Cities & Knights"> Base + Seafarers + Cities & Knights
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Rise of the Inkas"> Rise of the Inkas
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Dragons & Treasures"> Dragons & Treasures
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="Rivals for Catan"> Rivals for Catan
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="1V1 (14VP - Colonist)"> 1V1 (14VP - Colonist)
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameMode" value="King of Catan Playoffs"> King of Catan Playoffs
        </label>
        <span id="kocf-rs-game-mode-error" class="kocf-error-span"></span>
      </div>
      <div class="kocf-col-wrapper">
        <label class="kocf-labels">What scenario was played?<sup class="kocf-required">*</sup></label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The First Island (Suggested)"> The First Island (Suggested)
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Ore for wool"> Ore for wool
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Harbormaster"> The Harbormaster
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Heading for New Shores"> Heading for New Shores
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Four Islands"> The Four Islands
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Through the Desert"> Through the Desert
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Oceania"> Oceania
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Drought"> Drought
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Oases"> The Oases
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Treasure Islands"> The Treasure Islands
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Fog Islands"> The Fog Islands
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Greater Catan"> Greater Catan
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Rise of the Inka"> Rise of the Inka
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Enchanted Land"> Enchanted Land
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="The Great Canal"> The Great Canal
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Rivals - First Catanians (Introduction Game Mode)"> Rivals - First Catanians (Introduction Game Mode)
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Rivals - Themed Game"> Rivals - Themed Game
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="Rivals - Duel of the Princes"> Rivals - Duel of the Princes
        </label>
        <label class="kocf-radio-label-wrapper">
          <input type="radio" class="kocf-radio" name="kocfRsGameScenario" value="1V1 (14VP - Colonist)"> 1V1 (14VP - Colonist)
        </label>
        <span id="kocf-rs-game-scenario-error" class="kocf-error-span"></span>
      </div>
      <div class="kocf-col-wrapper kocf-results-buttons-wrapper">
        <button class="kocf-buttons" id="kocf-rs-submit">Submit Result</button>
      </div>
    </div>
    <div class="kocf-col-wrapper errors-div" id="kocf-rs-error-wrapper">

    </div>
	</form>
  <div class="kocf-col-wrapper" id="kocf-rs-success">
		<h2>Results submitted.</h2>
	</div>
<?php }
