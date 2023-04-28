<section class="search-bar">
    <h4>Search for product</h4>
    <div class="search-box">
        <form action="index.php" method="get">
            <div class="input-box">
                <label for="item">Product name</label>
                <input type="text" name="item" placeholder="Item name" />
            </div>
            <div class="input-box">
                <label for="pickup_date">Pickup date</label>
                <input type="date" name="pickup_date" />
            </div>
            <div class="input-box">
                <label for="location">Location</label>
                <input type="text" name="location" placeholder="Store location" />
            </div>
            <div class="input-box">
                <label for="price-type">Price Type</label>
                <select name="price-type">
                    <option value="H"<?php if ($_GET['price-type'] == 'H') { echo ' selected'; } ?>>Hourly</option>
                    <option value="D"<?php if ($_GET['price-type'] == 'D') { echo ' selected'; } ?>>Daily</option>
                </select>
            </div>
            <div class="submit-box">
                <button type="submit"><img src="assets/search.svg" alt="Search Icon"></button>
            </div>
        </form>
        <p class="search-message">In order to update the following products, please press the search icon.</p>
    </div>
</section>