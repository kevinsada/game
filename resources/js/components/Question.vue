<template>
    <div class="row">
        <div class="col-11">
            <div class="card bg-success">
                <div class="card-header">
                    <span>Category: {{data.category.name}}</span>
                    <span  style="border: 10px" >
                          Difficulty: {{difficulty}}
                    </span>
                    <span style="float: right">
                    Points: {{questionPoints}}
                </span>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Question {{count}}: {{question}}
                </div>
                <div class="card-body">
                    <ul style="list-style: none">
                        <li v-for="answer in answers">
                            <input type="radio" :value="answer" v-model="selectedAnswer" name="answer">
                            {{answer.answer}}
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" @click="submit">Submit answer</button>
                </div>
            </div>
        </div>
        <div class="col-1">
            {{countdown}}
        </div>
    </div>
</template>
<script>

    import axios from 'axios'

    export default {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                selectedAnswer: null,
                question: null,
                data: {
                    category: {
                        name: null,
                    },
                    difficulty: {
                        name: null,
                    },
                },
                difficulty: '',
                answers: null,
                count: 0,
                questionPoints: 0,
                totalPoints: 0,
                countdown: 10,
            }
        },
        methods: {
            countDownTimer() {
                if (this.countdown > 0) {
                    setTimeout(() => {
                        this.countdown -= 1
                        this.countDownTimer()
                    }, 1000)
                }
                if (this.countdown === -1) {
                    alert("you have failed")
                    this.failedToAnswer()
                }
            },
            failedToAnswer() {

            },
            fetchQuestion() {
                Echo.channel('user.game')
                    .listen('FetchQuestion', (e) => {
                        console.log(e.user);
                        console.log(e.question);
                        this.data = e.data;
                        this.question = e.data.question;
                        this.answers = e.data.answers;
                        this.count++;

                        this.difficulty =
                            this.data.difficulty.name.charAt(0).toUpperCase() +
                            this.data.difficulty.name.substring(1)

                        if (this.data.difficulty.name === 'easy') {
                            this.questionPoints = 1;
                        }
                        if (this.data.difficulty.name === 'medium') {
                            this.questionPoints = 2;
                        }
                        if (this.data.difficulty.name === 'hard') {
                            this.questionPoints = 3;
                        }
                    });

                axios.get('/api/question?user_id=' + this.user.id).then(response => {
                    this.data = response.data.data;
                    this.question = response.data.data.question;
                    this.answers = response.data.data.answers;
                    this.count++;

                    this.difficulty =
                        this.data.difficulty.name.charAt(0).toUpperCase() +
                        this.data.difficulty.name.substring(1)

                    if (this.data.difficulty.name === 'easy') {
                        this.questionPoints = 1;
                    }
                    if (this.data.difficulty.name === 'medium') {
                        this.questionPoints = 2;
                    }
                    if (this.data.difficulty.name === 'hard') {
                        this.questionPoints = 3;
                    }
                })
            },
            submit() {
                if (!this.selectedAnswer) {
                    alert('Chose an answer')
                    return;
                }
                axios.post('/api/question', {
                    question_id: this.data.id,
                    answer_id: this.selectedAnswer.id,
                    is_correct: this.selectedAnswer.is_correct,
                    points: this.selectedAnswer.is_correct ? this.questionPoints : parseInt('-' + this.questionPoints),
                    user_id: this.user.id,
                    count: this.count
                }).then(response => {

                })
            }
        },
        mounted() {

            this.fetchQuestion()

            this.countDownTimer()
        }
    }

</script>
