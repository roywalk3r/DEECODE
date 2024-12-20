// utils/flowControl.js
const flows = {
    debugging: [
        { step: 1, prompt: "What error are you encountering?" },
        { step: 2, prompt: "Can you provide the code that's causing the issue?" },
        // Add more steps as needed
    ],
    // Other flows can be added here
};

function getNextStep(flowName, currentStep) {
    const flow = flows[flowName];
    if (!flow) return null;

    const nextStep = flow.find(step => step.step === currentStep + 1);
    return nextStep ? nextStep.prompt : null;
}

module.exports = { getNextStep };
