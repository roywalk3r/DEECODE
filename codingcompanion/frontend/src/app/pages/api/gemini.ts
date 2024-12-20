export default async function handler(req, res) {
    if (req.method !== 'POST') {
        res.setHeader('Allow', ['POST']);
        return res.status(405).end(`Method ${req.method} Not Allowed`);
    }

    const { prompt } = req.body;

    try {
        const apiResponse = await fetch('http://localhost:3000/api/gemini/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ prompt })
        });

        if (!apiResponse.ok) {
            throw new Error('Error fetching response from backend');
        }

        const data = await apiResponse.json();
        res.status(200).json(data);
    } catch (error) {
        res.status(500).json({ error: 'Failed to connect to backend' });
    }
}
