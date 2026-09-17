<h2>You have been invited</h2>

<p>
    You have been invited to join:
    <strong>{{ $invitation->company->name }}</strong>
</p>

<p>
    Role: <strong>{{ $invitation->role }}</strong>
</p>

<p>
    Please use the invitation link below:
</p>

<a href="{{ url('/invitations/' . $invitation->token) }}">
    Accept Invitation
</a>