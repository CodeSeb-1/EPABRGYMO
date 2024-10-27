<?php

function sidebar($current_page) {
    echo '
        <nav class="sidebars">
            <a href="secretary_calendar.php">
                <div class="menu-item' . ($current_page === 'calendar' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Events</span>
                </div>
            </a>
            <a href="secretary_news.php">
                <div class="menu-item' . ($current_page === 'news' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">breaking_news</span>                
                    <span>News</span>
                </div>
            </a>
            <a href="secretary_document_request.php">
                <div class="menu-item' . ($current_page === 'request' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">description</span>                    
                    <span>Document Request</span>
                </div>    
            </a>
            <a href="secretary_chat.php">
                <div class="menu-item' . ($current_page === 'chat' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">chat</span>                
                    <span>Chat</span>
                </div>
            </a>
            <a href="secretary_resident_database.php">
                <div class="menu-item' . ($current_page === 'resident' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">groups</span>                    
                    <span>Master List</span>
                </div> 
            </a>
            <a href="secretary_ordinance_shifting.php">
                <div class="menu-item' . ($current_page === 'ordinance' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">task</span>                    
                    <span>Ordinance Shifting</span>
                </div> 
            </a>
             <a href="secretary_reports.php">
                <div class="menu-item' . ($current_page === 'reports' ? ' active' : '') . '">
                    <span class="material-symbols-outlined">report</span>                    
                    <span>Reports</span>
                </div> 
            </a>
        </nav>';
}
