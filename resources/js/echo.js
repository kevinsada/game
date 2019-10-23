debugger;
import Event from './event';

Echo.channel('user.game')
    .listen('FetchQuestion', (data) => {
        Event.$emit('question_fetched', data);
    });
