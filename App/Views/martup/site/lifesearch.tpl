<div class="search__area">
    <div class="container" >
        <div class="row" >
            <div class="col-md-12" >
                <div class="search__inner">
                    <form action="/search" method="post">
                        <input name="search_query" placeholder="<?=$text_where_search?>... " type="text" />
                        <ul class="search_filter">
                            <li><input id="users" type="radio" name="search_local" value="users" /> <label for="users"><?=$text_users?></label></li>
                            <li><input id="portfolio" type="radio" name="search_local" value="portfolio" /> <label for="portfolio"><?=$text_allportfolio?></label></li>
                            <li><input id="adverts" type="radio" name="search_local" value="adverts" /> <label for="adverts"><?=$text_adverts?></label></li>
                            <li><input id="vacancies" type="radio" name="search_local" value="vacancies" /><label for="vacancies"><?=$text_vacancies?></label></li>
                        </ul>
                        <button type="submit"></button>
                    </form>
                    <div class="search__close__btn">
                        <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>