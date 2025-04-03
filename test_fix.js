// Test function that simulates the date parsing functionality with the fixed RegExp
function testDateParsing(input, match) {
    console.log(`\nTesting with input: ${input.slice(0, 50)}${input.length > 50 ? '...' : ''} and match: ${match}`);
    
    const start = Date.now();
    try {
        // Simulate the original function's logic with our safety improvements
        const size = (match === "@" ? 14 : (match === "!" ? 20 : (match === "y" ? 4 : (match === "o" ? 3 : 2))));
        const minSize = (match === "y" ? size : 1);
        
        // Our fixed version with validation
        const maxAllowedSize = 20;
        const validatedSize = Math.min(size, maxAllowedSize);
        const validatedMinSize = Math.min(minSize, validatedSize);
        const digits = new RegExp("^\\d{" + validatedMinSize + "," + validatedSize + "}");
        
        const num = input.match(digits);
        const duration = Date.now() - start;
        
        if (!num) {
            console.log(`No match found. Time taken: ${duration}ms`);
            return null;
        }
        
        console.log(`Success! Matched: ${num[0]}, Time taken: ${duration}ms`);
        return parseInt(num[0], 10);
    } catch (e) {
        const duration = Date.now() - start;
        console.log(`Error: ${e}, Time taken: ${duration}ms`);
        return null;
    }
}

// Test cases
console.log("1. Normal case - year");
testDateParsing("2023", "y");

console.log("\n2. Normal case - month");
testDateParsing("12", "o");

console.log("\n3. Edge case - very long input (potential ReDoS trigger)");
testDateParsing("1".repeat(100000) + "a", "@");

console.log("\n4. Edge case - long valid input");
testDateParsing("1".repeat(30), "@");

console.log("\n5. Edge case - mixed valid/invalid");
testDateParsing("123abc", "o");

console.log("\n6. Edge case - empty input");
testDateParsing("", "o");

console.log("\n7. Edge case - maximum size test");
testDateParsing("12345678901234567890123", "!");

console.log("\n8. Edge case - minimum size test for year");
testDateParsing("123", "y");