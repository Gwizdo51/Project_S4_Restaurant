// returns a string in which the HTML characters are decoded
// https://stackoverflow.com/a/7394787/16509326
export function decodeHtml(encodedHtml) {
    const textArea = document.createElement("textarea");
    textArea.innerHTML = encodedHtml;
    return textArea.value;
}
