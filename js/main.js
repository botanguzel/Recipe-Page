const fetchRecipes = async (type) => {
    try {
        const response = await fetch('../php/fetch.php?type='+type);
        if (!response.ok) {
        throw new Error('Error fetching duyurular: ' + response.status);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching duyurular:', error);
        return [];
    }
};