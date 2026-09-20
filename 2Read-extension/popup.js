document.getElementById('saveBtn').addEventListener('click', async () => {
    const statusDiv = document.getElementById('status');
    statusDiv.innerText = "Lendo página...";

    try {
        const [tab] = await chrome.tabs.query({
            active: true,
            currentWindow: true
        });

        const { apiToken } = await chrome.storage.local.get('apiToken');

        const isInternalPage =
            tab.url.startsWith("chrome://") ||
            tab.url.startsWith("edge://") ||
            tab.url.startsWith("devtools://") ||
            tab.url.startsWith("chrome-extension://") ||
            tab.url.includes("chromewebstore.google.com");

        if (isInternalPage) {
            statusDiv.innerText = "Não é possível ler páginas internas do navegador.";
            return;
        }

        await chrome.scripting.executeScript({
            target: { tabId: tab.id },
            files: ['libs/readability-main/Readability.js']
        });

        const results = await chrome.scripting.executeScript({
            target: { tabId: tab.id },
            func: extractPageData,
        });

        if (!results || !results[0] || !results[0].result) {
            statusDiv.innerText = "Erro: Nenhum dado retornado da página.";
            return;
        }

        const pageData = results[0].result;

        const response = await fetch('http://localhost:80/api/v1/pages', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${apiToken}`
            },
            body: JSON.stringify(pageData)
        });

        if (!response.ok) {
            statusDiv.innerText = `Erro HTTP ${response.status}`;
            return;
        }

        statusDiv.innerText = "Página salva com sucesso!";
        
    } catch (error) {
        console.error("ERRO:", error);
        statusDiv.innerText = "Houve um erro ao ler a página";
    }
});

/** Esta função roda dentro da aba atual do usuário */
function extractPageData() {
    const documentClone = document.cloneNode(true);

    let article = null;
    try {
        const reader = new Readability(documentClone);
        article = reader.parse();
    } catch (e) {
        console.warn("Readability falhou ao analisar o DOM:", e);
    }

    // Garante que 'content' e 'title' nunca vão vazios/undefined
    const contentHtml = (article && article.content && article.content.trim() !== "")
        ? article.content
        : document.body.innerHTML;

    const pageTitle = (article && article.title && article.title.trim() !== "")
        ? article.title
        : document.title;

    return {
        url: window.location.href,
        title: pageTitle || "Página sem título",
        content: contentHtml
    };
}