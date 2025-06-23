

<form id="formData">
    @csrf
<input type="hidden" name="status" value="{{$request->status}}">
<input type="hidden" name="id" value="{{$request->id}}">
<label for="myCheckbox">Do you Want to Notify</label>

<input type="checkbox" id="myCheckbox" name="myCheckbox">
</form>