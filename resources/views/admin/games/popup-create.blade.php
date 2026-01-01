<form action="{{ route('admin.game.store') }}" method="POST" onsubmit="submitForm(event,this)">
@csrf
<h4>Add Game</h4>
<label>Game Name</label>
<input name="name" class="form-control" required>
<br>
<button class="btn btn-primary btn-block">Submit</button>
</form>
