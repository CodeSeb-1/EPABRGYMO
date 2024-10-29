<style>
    a {
        text-decoration: none;
    }
</style>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

class Calendar {

    private $active_year, $active_month, $active_day;
    private $events = [];
    private $show_full_year;

    public function __construct($date = null, $show_full_year = false) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
        $this->show_full_year = $show_full_year; // Initialize the property
    }

    public function add_event($id, $txt, $date, $days = 1, $color = '', $description = '', $address = '') {
        $color = $color ? ' ' . $color : '';
        $this->events[] = [
            'event_id' => $id,
            'name' => $txt, 
            'date' => $date, 
            'days' => $days, 
            'color' => $color,
            'description' => $description,
            'address' => $address
        ];
    }
    

    public function __toString() {
        if ($this->show_full_year) {
            return $this->generate_full_year_calendar();
        } else {
            return $this->generate_month_calendar($this->active_month);
        }
    }

    private function generate_month_calendar($month) {
        $num_days = date('t', strtotime($this->active_day . '-' . $month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $month . '-' . $this->active_year)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $month . '-' . $this->active_day));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';

        // Day names
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }

        // Days from the last month
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month - $i + 1) . '
                </div>
            ';
        }

        // Days of the current month
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = ($i == $this->active_day) ? ' selected' : '';
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            
            // Build events HTML for the current day
            $events_html = '';
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event['days'] - 1); $d++) {
                    if (date('Y-m-d', strtotime($this->active_year . '-' . $month . '-' . $i . ' -' . $d . ' day')) == date('Y-m-d', strtotime($event['date']))) {
                        $events_html .= " <a href='secretary_calendar.php?&event_id_tag={$event['event_id']}'>";
                        $events_html .= '<div class="event' . $event['color'] . '">';
                        $events_html .= "Event: {$event['name']}";
                        $events_html .= '<div class="address"> Location: ' . $event['address'] . '</div>';
                        $events_html .= '</div>';
                        $events_html .= '</a>';
                    }
                }
            }
            

            // Append events HTML if exists
            if ($events_html) {
                $html .= $events_html;
            }
            $html .= '</div>';
        }

        // Days from the next month
        for ($i = 1; $i <= (42 - $num_days - max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }

        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    private function generate_full_year_calendar() {
        $html = '<div class="full-year-calendar">';
        for ($month = 1; $month <= 12; $month++) {
            $this->active_month = str_pad($month, 2, '0', STR_PAD_LEFT);
            $html .= $this->generate_month_calendar($this->active_month);
        }
        $html .= '</div>';
        return $html;
    }

}
