<?php if (isset($variables['message'])): ?>
  <p class="notice notice-info">
    <?php echo $variables['message'] ?>
  </p>
<?php endif ?>

<h3>New channel</h3>
<form method="post">
  <p>
    Generating a new channel means that a new private channel will be created in Slack and a user from the "Slack member ID" field will be invited to the channel.
  </p>
  <p>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">Slack member ID</th>
          <td>
            <input type="text" name="user-id" id="user-id" required>
            <p class="description" id="tagline-description">Where to find it? Try this Medium <a target="_blank" href="https://moshfeu.medium.com/how-to-find-my-member-id-in-slack-workspace-d4bba942e38c">article</a>.</p>
          </td>
        </tr>
        <tr>
          <th scope="row">Channel name</th>
          <td>
            <input type="text" name="name" id="name" required>
            <p class="description" id="tagline-description">Channel names have a 21 character limit and can include lowercase letters, non-Latin characters, numbers and hyphens.</p>
          </td>
        </tr>
        <tr>
          <th scope="row">Refresh interval</th>
          <td>
            <input type="number" name="name" id="name" value="3" min="1" required>
            <p class="description" id="tagline-description">How often messages refresh when users view the channel, in seconds.</p>
          </td>
        </tr>
      </tbody>
    </table>

    <input type="hidden" name="action" id="action" value="channel-new">
    <input type="submit" name="generate-new-channel" id="generate-new-channel" class="button button-primary" value="Generate new channel">
  </p>
</form>
<hr>

<h3>Existing channels</h3>

<table class="slack-liveblog-channels-list">
  <thead>
    <tr>
      <th>Name</th>
      <th>Slack ID</th>
      <th>Slack url</th>
      <th>Owner ID</th>
      <th>Tag</th>
      <th>Refresh interval</th>
      <th>Closed</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($variables['channels'] as $channel): ?>
      <?php
        $slack_channel_url = "{$variables['slack_home_path']}/archives/{$channel->slack_id}";
      ?>
      <tr data-id="<?php echo $channel->id ?>">
        <td><?php echo $channel->name ?></td>
        <td><?php echo $channel->slack_id ?></td>
        <td>
          <a target="_blank" href=<?php echo $slack_channel_url ?>>
            <?php echo $slack_channel_url ?>
          </a>
        </td>
        <td><?php echo $channel->owner_id ?></td>
        <td>
          [slack_liveblog channel_id="<?php echo $channel->slack_id ?>"/]
        </td>
        <td>
          <div>
            <input type="number" min="1" value="<?php echo $channel->refresh_interval ?>" class="slack-liveblog-channels-list-refresh-interval" data-key="refresh_interval"> sec
          </div>
          <a class="slack-liveblog-channels-list-action"
             data-action="update-refresh-interval"
             data-success-message="Refresh interval has been saved successfully."
             data-elements-submit=".slack-liveblog-channels-list-refresh-interval"
          >Save</a>
        </td>
        <td>
          <div>
            <?php echo SlackLiveblog\Helpers::get_bool_yes_no($channel->closed) ?>
          </div>
          <a class="slack-liveblog-channels-list-action"
             data-action="channel-toggle"
             data-success-message="Closed status has been saved successfully."
             data-success-callback="closedChange"
             data-elements-submit=".slack-liveblog-channels-list-status"
          ><?php echo SlackLiveblog\Helpers::get_channel_open_close($channel->closed) ?></a>
          <input type="hidden" class="slack-liveblog-channels-list-status" value="<?php echo !$channel->closed ?>" data-key="status">
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
