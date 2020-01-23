import 'babel-polyfill';

document.getElementById('codeSplittingButton').addEventListener('click', async () => {
        const { Messages } = await import ('../main');
        console.log(Messages.SayHello());
    });