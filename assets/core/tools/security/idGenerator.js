var { v4: uuidv4 } = require("uuid");
var key = 1;

function idGenerator() {
	key = key + 1;
	var currentTimestampInSecond = Math.floor(Date.now() / 1000);
	var timestamp = currentTimestampInSecond.toString(36);
	var timestampShuffle = shuffle(timestamp + "");
	var result = `${uuidv4()}${key}${timestamp}-${timestampShuffle}`;
	return result;
}

function shuffleBin(text) {
	var txts = text.split("");
	return txts
		.sort(() => {
			return 0.5 - Math.random();
		})
		.join("");
}

function shuffle(text) {
	var txts = text.split("");
	txts.map(() => {
		text = shuffleBin(text);
	});
	return text;
}

export { idGenerator };
