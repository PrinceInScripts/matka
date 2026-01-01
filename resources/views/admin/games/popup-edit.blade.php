<form action="{{ route('admin.game.update',$game->id) }}" method="POST" onsubmit="submitForm(event,this)">
@csrf
<h4>Update Game</h4>
<label>Game Name</label>
<input name="name" class="form-control" value="{{ $game->name }}" required>
<br>
<button class="btn btn-primary btn-block">Update</button>
</form>
