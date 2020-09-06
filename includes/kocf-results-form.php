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
    <div class="kocf-col-wrapper">
      <label for="kocf-rs-winner">Who won the game?<sup class="kocf-required">*</sup></label>
      <select name="kocfRsWinner" class="kocf-select-box" required>
        <option value="">Select Winner</option>
        <?php foreach ($users as $row){ ?>
          <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
        <?php } ?>
      </select>
			<span id="kocf-rs-winner-error" class="kocf-error-span"></span>
    </div>
    <div class="kocf-col-wrapper">
      <label>Who were the other participating players?</label>
      <p>(Please include all players)</p>
    </div>
    <div class="kocf-col-wrapper">
      <label for="kocf-rs-player2">Player 2<sup class="kocf-required">*</sup></label>
      <select name="kocfRsPlayer2" class="kocf-select-box" required>
        <option value="">Select Player 2</option>
        <?php foreach ($users as $row){ ?>
          <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
        <?php } ?>
      </select>
			<span id="kocf-rs-player2-error" class="kocf-error-span"></span>
    </div>
    <div class="kocf-col-wrapper">
      <label for="kocf-rs-player3">Player 3</label>
      <select name="kocfRsPlayer3" class="kocf-select-box">
        <option value="">Select Player 3</option>
        <?php foreach ($users as $row){ ?>
          <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
        <?php } ?>
      </select>
			<span id="kocf-rs-player3-error" class="kocf-error-span"></span>
    </div>
    <div class="kocf-col-wrapper">
      <label for="kocf-rs-player4">Player 4</label>
      <select name="kocfRsPlayer4" class="kocf-select-box">
        <option value="">Select Player 4</option>
        <?php foreach ($users as $row){ ?>
          <option value="<?php echo $row->user_id ?>"><?php echo $row->user_email_id ?></option>
        <?php } ?>
      </select>
			<span id="kocf-rs-player4-error" class="kocf-error-span"></span>
    </div>
    <div class="kocf-col-wrapper">
      <label for="kocf-rs-other-players">Other player(s) not in the list</label>
	    <input type="text" name="kocfRsOtherPlayers" class="kocf-input-box" />
			<span id="kocf-rs-other-players-error" class="kocf-error-span"></span>
    </div>
    <div class="kocf-col-wrapper errors-div" id="kocf-rs-error-wrapper">

		</div>
	</form>
<?php }
