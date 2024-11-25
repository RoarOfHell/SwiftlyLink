@if($user->isOnline($chat->user_id))
<div class="status-wrapper">
    <div class="status-online"></div>
</div>
@else
<div class="status-wrapper">
    <div class="offline-wrapper">
        <div class="status-offline"></div>
    </div>
</div>
@endif