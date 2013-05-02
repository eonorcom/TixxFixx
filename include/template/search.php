
            <div id="search">   
                <form class="form-search" id="search-form" method="get" action="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $category ?>">
                <div class="input-append">
                    <input id="search-box" type="text" class="span2 search-query" name="search" value="<?php echo $search ?>" placeholder="Search for an event!">
                    <button type="button" id="search-button" value="Search" type="submit" class="btn" onclick="$('#search-form').submit()">Search</button>
                </div>
                </form>
			</div>