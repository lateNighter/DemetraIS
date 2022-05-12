// import {mockData} from './mockData.js';
import {Calendar} from './calendar.js';

moment.locale('ru');
document.addEventListener("DOMContentLoaded", async ()=>{
    const cal = Calendar('calendar');
    cal.render();
    $.ajax({
        type: 'Get',
        url: '../../database/fridge-show.php',
        success: function(data){
            // console.log(data);
            var arr = JSON.parse(data);
            cal.bindData(arr);
            cal.render();
        }
    });
    
});