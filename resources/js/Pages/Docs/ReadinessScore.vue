<script>
export default {
    name: "ReadinessScore"
}
</script>

<template>
    <div class="prose">
        <h1>Understanding Your Readiness Score: A Guide</h1>
        <p>In our learning platform, we are dedicated to providing you with comprehensive tools to track your progress
            and readiness for your RBT (Registered Behaviour Technician) exams. A pivotal element of this tracking is
            your "Readiness Score." This guide is designed to help you understand how your Readiness Score is
            calculated, what it represents, and how you can use this information to enhance your learning
            experience.</p>

        <h2>What is the Readiness Score?</h2>
        <p>The Readiness Score is a numerical representation of your current level of preparedness for the RBT
            examination. It is derived from your performance across various task list categories covered in the practice
            exams. This score is calculated by analysing your accuracy rates in these categories, providing a clear and
            concise metric of your readiness.</p>

        <h2>How is the Readiness Score Calculated?</h2>
        <ol>
            <li><strong>Examination Structure</strong>: Our practice exams are structured to cover all the task list
                categories necessary for the RBT exam. Each exam consists of a specified number of questions (X) from
                every task list category.
            </li>
            <li><strong>Selection of Questions</strong>: To calculate your Readiness Score, we take the last X questions
                you've answered in each task list category and then select an additional 2 questions from those
                attempts. This selection aims to analyse your most recent performance, ensuring the score reflects your
                current understanding and readiness.
            </li>
            <li><strong>Accuracy Rate Calculation</strong>: For each task list category, we calculate your accuracy rate
                based on the selected questions. This is done by dividing the number of questions you answered correctly
                by the total number of questions considered (X + 2), resulting in a percentage that reflects your
                proficiency in that specific category.
            </li>
            <li><strong>Average Accuracy Rate</strong>: Once we have calculated the accuracy rates for all task list
                categories, we compute the average of these rates. This average accuracy rate forms your Readiness
                Score.
            </li>
        </ol>

        <h2>Interpreting Your Readiness Score</h2>
        <p>Your Readiness Score is a dynamic measure of your current ability to successfully pass the RBT examination,
            with a higher score indicating greater readiness. It is crucial to understand that this score is not static;
            it will fluctuate as you continue to engage with practice questions and refine your understanding of the
            task list categories. A Readiness Score of 80% or higher is considered indicative of being well-prepared for
            the RBT examination.</p>

        <h2>Conclusion</h2>
        <p>Your Readiness Score is a valuable tool in your journey towards RBT certification, offering a clear
            indication of your strengths and areas for improvement. By understanding how this score is calculated and
            what it signifies, you can tailor your study approach to enhance your readiness for the RBT exam
            effectively. Continue to engage with the practice exams and utilise your score as a guide to ensure your
            preparation is focused and efficient.</p>
    </div>
</template>

<style scoped>
</style>
