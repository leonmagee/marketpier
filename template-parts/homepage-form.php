<!-- @todo this should pull options from custom field repeater -->
<div class="search-form-wrap">
    <form method="post" action="#"><!-- @todo form action to switch page to search results? -->
        <input type="hidden" name="listing-search-form" />
        <div class="input-wrap status" data-toggle="status-dropdown">
            <div class="select-toggle">For Sale</div>
            <i class="fa fa-sort" aria-hidden="true"></i>
            <div class="dropdown-pane" id="status-dropdown" data-dropdown data-hover="true" data-hover-pane="true">
                <ul>
                    <li>For Sale</li>
                    <li>For Lease</li>
                    <li>Sold Listings</li>
                </ul>
            </div>
            <input class="hidden-input" type="hidden" name="status"/>
        </div>
        <div class="input-wrap property-type" data-toggle="property-type-dropdown">
            <div class="select-toggle">All Property Types</div>
            <i class="fa fa-sort" aria-hidden="true"></i>
            <div class="dropdown-pane" id="property-type-dropdown" data-dropdown data-hover="true"
                 data-hover-pane="true">
                <ul>
                    <li>Multifamily</li>
                    <li>Office</li>
                    <li>Retail</li>
                    <li>Industrial</li>
                    <li>Hotel / Motel</li>
                    <li>Land</li>
                    <li>Residential Income</li>
                    <li>Business Opportunity</li>
                </ul>
            </div>
            <input class="hidden-input" type="hidden" name="property-type"/>
        </div>
        <div class="input-wrap main-input">
            <input type="text" placeholder="Search City, State, or Area" name="city-state-area"/>
            <i class="fa fa-search" aria-hidden="true"></i>
        </div>
        <input class="submit-input" type="submit" value="Submit"/>
    </form>
</div>