const express = require('express');
const router = express.Router();

const {ClarifaiStub, grpc} = require("clarifai-nodejs-grpc");
const stub = ClarifaiStub.grpc();
const metadata = new grpc.Metadata();
metadata.set("authorization", "Key f1b91994ff22442b97d4b07eb0089d9b");

router.post('/', (req, res, next) => {
    const { link } = req.body;
    
    stub.PostModelOutputs(
        {
            model_id: "bd367be194cf45149e75f01d59f77ba7",
            inputs: [
                {
                    data: {
                        image: {
                            url: link
                        }
                    }
                }
            ]
        },
        metadata,
        (err, response) => {
            if (err) {
                console.log("Error: " + err);
                res.status(500).json({
                    "statusCode": 500,
                    "message": "Server Error"
                });
            }
    
            if (response.status.code !== 10000) {
                console.log("Received failed status: " + response.status.description + "\n" + response.status.details);
                res.status(500).json({
                    "statusCode": 500,
                    "errorDesc": + response.status.description,
                    "errorDetails": response.status.details
                })
            }
    
            console.log("Predicted concepts, with confidence values:")
            result = []
            for (const c of response.outputs[0].data.concepts) {
                console.log(c.name + ": " + c.value);
                result.push({
                    "name": c.name,
                    "value": c.value
                });
            }
            // console.log(result);
            res.status(200).json({
                "result": result
            })
            
        }
    )
});

module.exports = router;