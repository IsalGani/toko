<div class="form-group">
    <label>Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
</div>
<div class="form-group">
    <label>Level</label>
    <select name="level" class="form-control" required>
        <option value="1">Admin</option>
        <option value="2">Kasir</option>
        <option value="0">Pelanggan</option>
    </select>
</div>
<button type="submit" class="btn btn-primary">{{ $submit }}</button>
