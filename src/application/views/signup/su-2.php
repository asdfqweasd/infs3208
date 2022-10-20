<div class="container-md my-3">
<h2>Sign Up - Step 2</h2>
<br>
</div>
<div class="container-md my-3">
    <form method="post">
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender">
                <option>Female</option>
                <option>Male</option>
                <option>Prefer not to tell</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="formControlRange">Percentage of Grey Hair</label>
            <input type="range" class="form-control-range" id="percentGrey">
        </div>
        <br>
        <div class="form-group">
            <label for="formControlRange">Hair Thickness</label>
            <input type="range" class="form-control-range" id="hairThickness">
        </div>
        <br>
        <div class="form-group">
            <label for="scalp">Sensitive Scalp?</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="scalp">
                <label class="form-check-label" for="defaultCheck1">Yes</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
